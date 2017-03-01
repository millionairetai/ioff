<?php

namespace member\controllers;

use Yii;
use common\models\Company;
use common\models\PlanType;
use common\models\Order;
use common\models\OrderItem;
use common\models\Invoice;
use common\models\InvoiceDetail;
use common\models\EmailTemplate;
use common\models\Status;
use common\models\File;
use common\components\web\IoffDatetime;

class CompanyController extends ApiController {

    /**
     * Get list of actions
     */
    public function actionIndex() {
//    return $this->sendResponse(false, "", Action::getTranslation());
    }

    /**
     * View company info
     */
    public function actionView() {
        $objects = [];
        try {
            $company = Company::getDetailByCompanyId(Yii::$app->user->identity->company_id);
            if (empty($company)) {
                throw new \Exception;
            }

            $company['total_storage'] = floor($company['total_storage'] / (1024 * 1024));
            $company['max_storage_register'] = $company['max_storage_register'] * 1000;
            $company['using_storage_percent'] = round(($company['total_storage'] / ($company['max_storage_register'])) * 100, 1);
            $company['using_user_percent'] = $company['max_user_register'] != 0 ? round($company['total_employee'] / ($company['max_user_register']) * 100, 1) : 0;
            $company['expired_date'] = empty($company['expired_date']) ? '--' : \Yii::$app->formatter->asDate($company['expired_date']);
            $company['start_date'] = \Yii::$app->formatter->asDate($company['start_date']);
            $company['plan_type_name'] = strtoupper($company['plan_type_name']);
            //Get person who create company's account.
            $employee = \common\models\Employee::getById($company['created_employee_id'], [
                        'firstname', 'lastname', 'email', 'mobile_phone', 'street_address_1']);

            if (empty($employee)) {
                throw new \Exception;
            }

            $company['employee'] = [
                'name' => $employee->fullname,
                'mobile_phone' => $employee->mobile_phone,
                'email' => $employee->email,
                'address' => $employee->street_address_1
            ];

            $objects = ['company' => $company,];
            return $this->sendResponse(false, "", $objects);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }

    /**
     * Change package.
     */
    public function actionChangePackage() {
        $objects = [];
        $orderInfo = null;
        try {
            $company = Company::getDetailByCompanyId(Yii::$app->user->identity->company_id);
            //Get plan type index by column name.
            $planTypeByColName = PlanType::getsIndexByColumnName();
            $planTypeIndexByIds = PlanType::getsIndexById();
            $post = Yii::$app->request->post();
            if (empty($company) || empty($planTypeByColName)|| empty($planTypeIndexByIds)) {
                throw new \Exception;
            }

            //Reset maxUser, maxStorage corresponding for plan type of free and premium.
            $post['planType'] = strtolower($post['planType']);
            if ($post['planType'] == PlanType::COLUMN_NAME_FREE) {
                $post['maxUser'] = $planTypeByColName[PlanType::COLUMN_NAME_FREE]['max_user'];
                $post['maxStorage'] = $planTypeByColName[PlanType::COLUMN_NAME_FREE]['max_storage'];
            } else if ($post['planType'] == PlanType::COLUMN_NAME_PREMIUM) {
                $post['maxUser'] = 0;
            }

            //Get error message. If error message is empty, we allow change package.
            $errorMessage = $this->_getErrorMessage($company, $post);
            if (empty($errorMessage)) {
                $orderInfo = [
                    'planTypeRegister' => strtoupper($post['planType']),
                    'maxUser' => ($post['maxUser'] != 0) ? $post['maxUser'] : Yii::t('common', 'Unlimited'),
                    'maxStorage' => ($post['maxStorage'] != 0) ? $post['maxStorage'] : Yii::t('common', 'Unlimited'),
                    'numberMonth' => !empty($post['numberMonth']) ? $post['numberMonth'] : Yii::t('common', 'Unlimited'),
                    //Calculate redundant money from the old package.
                    'redundantMoney' => $this->_getRedundantMoney($company, $planTypeIndexByIds),
                    'companyName' => $company['company_name'],
                    'firstname' => Yii::$app->user->identity->firstname,
                    'lastname' => Yii::$app->user->identity->lastname,
                    'phoneNo' => $company['phone_no'],
                    'email' => Yii::$app->user->identity->email,
                ];
                
                //Calculate total money for next plan
                switch ($post['planType']) {
                    case PlanType::COLUMN_NAME_FREE:
                        $orderInfo['nextPlanTotalMoney'] = 0;
                        break;
                    case PlanType::COLUMN_NAME_STANDARD:
                        $orderInfo['nextPlanTotalMoney'] = ($planTypeByColName[strtolower($post['planType'])]['fee_user'] * $post['maxUser'] + $planTypeByColName[strtolower($post['planType'])]['fee_storage'] * $post['maxStorage']) * $post['numberMonth'];
                        break;
                    case PlanType::COLUMN_NAME_PREMIUM:
                        $orderInfo['nextPlanTotalMoney'] = ($planTypeByColName[strtolower($post['planType'])]['fee_user'] + $planTypeByColName[strtolower($post['planType'])]['fee_storage'] * $post['maxStorage']) * $post['numberMonth'];
                        break;
                }

                $orderInfo['finalTotalMoney'] = $orderInfo['nextPlanTotalMoney'] - $orderInfo['redundantMoney'];
                $objects = ['orderInfo' => $orderInfo, 'error' => ['isTrue' => false, 'message' => '']];
            } else {
                $objects = ['orderInfo' => $orderInfo, 'error' => ['isTrue' => true, 'message' => $errorMessage]];
            }

            if (!empty($post['saveOrder'])) {
                try {
                    $transaction = \Yii::$app->db->beginTransaction();
                    $invoiceOrderNo = $this->_insertOrderInvoice($company, Yii::$app->user->identity, $planTypeByColName, $post);
                    $this->_sendOrderAndInvoiceEmail($company, Yii::$app->user->identity, $planTypeByColName, $invoiceOrderNo, $post, $orderInfo['finalTotalMoney']);
                    $transaction->commit();
                    $objects['orderInfo']['successOrderInvoice'] = true;
                } catch (\Exception $ex) { 
                    $transaction->rollBack();
                }
            }

            return $this->sendResponse(false, "", $objects);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }

    /**
     * Get error message
     *
     * @param array $company
     * @param array $post
     * @return string
     */
    private function _getErrorMessage($company, $post) {
        $company['max_storage_register'] = File::changeStorageType($company['max_storage_register'], 'B', 'GB');
        $post['maxStorage'] = File::changeStorageType($post['maxStorage'], 'B', 'GB');
        //Check whether company make invoice before or not. If have any order wait for payment, we are not allow to change.
        if (Order::isExistedWaitingPaymentOrder(\Yii::$app->user->identity->company_id)) {
            return 'Bạn có đã thay đổi gói đăng ký trước đó nhưng chưa thanh toán. Vui lòng thanh toán trước khi đổi sang gói mới';
        }
        //Must check user > old user and storage > old storage.
        $planType = PlanType::getsIndexById();
        if ($company['expired_date'] > IoffDatetime::getTimestamp()) {
            if ($planType[$company['plan_type_id']]['column_name'] == PlanType::COLUMN_NAME_FREE || $planType[$company['plan_type_id']]['column_name'] == PlanType::COLUMN_NAME_STANDARD) {
                if (strtolower($post['planType']) == PlanType::COLUMN_NAME_FREE) {
                    return Yii::t('member', 'Can not change standard to free plan type when it has not been expired yet');
                }

                if (strtolower($post['planType']) == PlanType::COLUMN_NAME_STANDARD && $post['maxUser'] > $company['max_user_register'] && $post['maxStorage'] > $company['max_storage_register']) {
                    return '';
                }
                
                if (strtolower($post['planType']) == PlanType::COLUMN_NAME_STANDARD && ($post['maxUser'] < $company['max_user_register'] || $post['maxStorage'] < $company['max_storage_register'])) {
                    return Yii::t('member', 'Can not reduce quantity of max user registed and max storage register down when it has not expired yet');
                }
                
                if (strtolower($post['planType']) == PlanType::COLUMN_NAME_STANDARD && $post['maxUser'] == $company['max_user_register'] && $post['maxStorage'] == $company['max_storage_register']) {
                    return Yii::t('member', 'Can not change current plan type which has same max user registered and max storage registered when not expired yet');
                }
                
                if (strtolower($post['planType']) == PlanType::COLUMN_NAME_PREMIUM && $post['maxUser'] > $company['max_user_register'] && $post['maxStorage'] > $company['max_storage_register']) {
                    return '';
                }
                
                if (strtolower($post['planType']) == PlanType::COLUMN_NAME_PREMIUM && $post['maxStorage'] <= $company['max_storage_register']) {
                    return Yii::t('member', 'Can not change to premium plan type which has max storage registered down when not expired yet');
                }

                return '';
            } else if ($planType[$company['plan_type_id']]['column_name'] == PlanType::COLUMN_NAME_PREMIUM) {
                if (strtolower($post['planType']) == PlanType::COLUMN_NAME_PREMIUM && ($post['maxStorage'] > $company['max_storage_register'])) {
                    return '';
                }

                return Yii::t('member', 'Can not degrade premiumn plan type or max user registered or max storage registered down when not expired yet');
            }
        } else {
            if ($planType[$company['plan_type_id']]['column_name'] == PlanType::COLUMN_NAME_FREE && strtolower($post['planType']) == PlanType::COLUMN_NAME_FREE) {
                return Yii::t('member', 'Can not change plan type from Free to Free');
            }
            
            if (strtolower($post['planType']) == PlanType::COLUMN_NAME_FREE && ($company['total_employee'] > $post['maxUser'] || $company['total_storage'] > $post['maxStorage'])) {
                return Yii::t('member', 'Total of employee or storage of company which is not allowed to be greater than max employee registered and max storage registered of plan type we change to');
            }
            
            if ($planType[$company['plan_type_id']]['column_name'] == PlanType::COLUMN_NAME_PREMIUM && ($company['total_storage'] > $post['maxStorage'] || ($company['total_employee'] > $post['maxUser'] && $post['maxUser'] > 0))) {
                return Yii::t('member', 'Total of employee or storage of company which is not allowed to be greater than max employee registered and max storage registered of plan type we change to');
            }

            if (!in_array($planType[$company['plan_type_id']]['column_name'], [PlanType::COLUMN_NAME_PREMIUM, PlanType::COLUMN_NAME_FREE]) && (($company['total_employee'] > $post['maxUser'] && $post['maxUser'] > 0 ) || $company['total_storage'] > $post['maxStorage'])) {
                return Yii::t('member', 'Total of employee or storage of company which is not allowed to be greater than max employee registered and max storage registered of plan type we change to');
            }

            return '';
        }
    }

    /**
     * Get redundant money
     *
     * @param array $company
     * @param array $planType
     * @return int
     */
    private function _getRedundantMoney($company, $planType) {
        $redundantMoney = 0;
        //invoice money - number of month using* (fee_user + fee_storage)
        $usedMonth = $this->diffInMonths(new \DateTime(IoffDatetime::getDate()), new \DateTime(date('Y-m-d', $company['start_date'])));
        //Calculate total money.
        switch ($planType[$company['plan_type_id']]['column_name']) {
            case 'free':
                $redundantMoney = 0;
                break;
            case 'standard':
                $redundantMoney = ($planType[$company['plan_type_id']]['fee_user'] * $company['max_user_register'] + $planType[$company['plan_type_id']]['fee_storage'] * $company['max_storage_register']) * $usedMonth;
                break;
            case 'premium':
                $redundantMoney = ($planType[$company['plan_type_id']]['fee_user'] + $planType[$company['plan_type_id']]['fee_storage'] * $company['max_storage_register']) * $usedMonth;
                break;
        }

        //Get total money from most recent invoice.
        $mostRecentInvoice = Invoice::getMostRecentInvoiceByCompanyId(\Yii::$app->user->identity->company_id);
        if (!$mostRecentInvoice) {
            return false;
        }
        
        $redundantMoney = $mostRecentInvoice['total_money'] - $redundantMoney;
        if ($redundantMoney < 0) {
            $redundantMoney = 0;
        }

        return $redundantMoney;
    }

    /**
     * Calculate the difference in months between two dates
     *
     * @param \DateTime $date1
     * @param \DateTime $date2
     * @return int
     */
    public static function diffInMonths(\DateTime $date1, \DateTime $date2) {
        $diff = $date1->diff($date2);
        $months = $diff->y * 12 + $diff->m + $diff->d / 30;
        return $months;
    }

    /**
     *  Insert order and invoice for company registration.
     *  @param object $company
     *  @param object $employee
     *  @param object $planType
     *  @param array $post
     * 
     *  @return boolean
     */
    private function _insertOrderInvoice($company, $employee, $planType, $post) {
        $order = new Order();
        $order->order_number = time();
        $order->employee_id = $employee->id;
        //Get status for order.;
        if ($post['planType'] == PlanType::COLUMN_NAME_FREE) {
            $status = Status::getByOwnerTableAndColumnName('order', Order::COLUNM_NAME_PAYED);
        } else {
            $status = Status::getByOwnerTableAndColumnName('order', Order::COLUNM_NAME_WAIT_PAY);
            $order->expired_datetime = strtotime(IoffDatetime::getDate() . ' +' . $post['numberMonth'] . ' month');
            $order->duedate = 0;
        }

        $order->status_id = $status['id'];
        if ($order->save(false) === false) {
            throw new \Exception('Save data to order table fail');
        }

        //Insert into order item.
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->plan_type_id = $planType[strtolower($post['planType'])]['id'];
        $orderItem->number_month = !empty($post['numberMonth']) ? $post['numberMonth'] : 0;
        $orderItem->max_user_register = $post['maxUser'];
        $orderItem->max_storage_register = $post['maxStorage'];
        $orderItem->discount = 0;
        if ($orderItem->save(false) === false) {
            throw new \Exception('Save data to order item table fail');
        }

        if (strtolower($post['planType']) != PlanType::COLUMN_NAME_FREE) {
            return true;
        }

        $invoice = new Invoice();
        $invoice->invoice_number = time();
        //Get status of employee which is active.
        $status = Status::getByOwnerTableAndColumnName('invoice', Invoice::COLUNM_NAME_PAYED);
        $invoice->status_id = $status['id'];
        $invoice->order_id = $order->id;
        $invoice->employee_id = $employee->id;
        if ($invoice->save(false) === false) {
            throw new \Exception('Save data to invoice table fail');
        }

        $invoiceDetail = new InvoiceDetail();
        $invoiceDetail->invoice_id = $invoice->id;
        //Free package -> number month = 0.
        $invoiceDetail->number_month = 0;
        $invoiceDetail->plan_type_id = $planType[strtolower($post['planType'])]['id'];
        $invoiceDetail->max_user_register = $post['maxUser'];
        $invoiceDetail->max_storage_register = $post['maxStorage'];
        if ($invoiceDetail->save(false) === false) {
            throw new \Exception('Save data to invoice detail table fail');
        }

        //Update max user and max storage in company table.
        if (!(new Company())->updateByArr([
                'max_user_register' => $post['maxUser'],
                'max_storage_register' => $post['maxStorage'],
                'plan_type_id' => $planType[strtolower($post['planType'])]['id'],
                'start_date' => IoffDatetime::getTimestamp(),
                'expired_date' => !empty($post['numberMonth']) ? strtotime(IoffDatetime::getDate() . ' +' . $post['numberMonth'] . ' month') : 0
            ], 
            $company['id']
        )) {
            throw new \Exception('No update anything in table company');
        }

        return [
            'invoiceNo' => $invoice->invoice_number,
            'orderNo' => $order->order_number,
        ];
    }

    /**
     *  Send order and invoice email for company registration.
     *  @param object $company
     *  @param object $employee
     *  @param object $planType
     *  @param array $invoiceOrderNo
     *  @param array $post
     *  @param array $totalMoney
     *  @return boolean
     */
    private function _sendOrderAndInvoiceEmail($company, $employee, $planType, $invoiceOrderNo, $post, $totalMoney) {
        $post['planType'] = strtolower($post['planType']);
        if ($company['plan_type_id'] == $planType[PlanType::COLUMN_NAME_FREE]['id']) {
            $themeEmail = EmailTemplate::getTheme(EmailTemplate::SUCCESS_COMPANY_REGISTRATION_FREE);
        } else {
            $themeEmail = EmailTemplate::getTheme(EmailTemplate::SUCCESS_COMPANY_REGISTRATION);
        }

        $dataSend = [
            '{fullname}' => $employee->fullname,
            '{name service}' => $company['company_name'],
            '{package name}' => $planType[$post['planType']]['name'],
            '{max user}' => !empty($post['maxUser']) ? $post['maxUser'] : strtolower(Yii::t('common', 'Unlimited')),
            '{max storage}' => $post['maxStorage'],
            '{total money}' => $totalMoney,
            '{number credit card}' => Yii::$app->params['number_credit_card'],
            '{support email}' => Yii::$app->params['support_email'],
            '{hot line number}' => Yii::$app->params['hot_line_number'],
            '{period time}' => !empty($post['numberMonth']) ? $post['numberMonth'] : strtolower(Yii::t('common', 'Unlimited')),
        ];

        $employee->sendMail($dataSend, $themeEmail);
        if ($post['planType'] != PlanType::COLUMN_NAME_FREE) {
            return true;
        }

        //Send invoice to employee if plan type is free.
        $themeEmail = EmailTemplate::getTheme(EmailTemplate::COMPANY_PAYMENT_INVOICE);
        $dataSend = [
            ///////Time db and php change here.
            '{date invoice}' => Yii::$app->formatter->asDate(IoffDatetime::getTimestamp()),
            '{service from}' => Yii::$app->params['service_from'],
            '{address from}' => Yii::$app->params['address_from'],
            '{phone from}' => Yii::$app->params['phone_from'],
            '{email from}' => Yii::$app->params['email_from'],
            '{fullname to}' => $employee->fullname,
            '{address to}' => $employee->street_address_1,
            '{phone to}' => $company['phone_no'],
            '{email to}' => $employee->email,
            '{invoice no}' => $invoiceOrderNo['invoiceNo'],
            '{order no}' => $invoiceOrderNo['orderNo'],
            '{account}' => $employee->email,
            '{product name}' => $planType[$post['planType']]['name'],
            '{description}' => sprintf(Yii::t('common', 'description invoice'), 
                    $planType[$post['planType']]['name'], 
                    !empty($post['maxUser']) ? $post['maxUser'] : Yii::t('common', 'Unlimited'), 
                    $post['maxStorage'],
                    !empty($post['numberMonth']) ? $post['numberMonth'] : strtolower(Yii::t('common', 'Unlimited'))
                ),
            '{subtotal}' => $totalMoney,
            '{payment method}' => Yii::t('common', 'Bank transfer'),
            '{tax percent}' => Yii::$app->params['tax_percent'],
            '{total tax}' => $totalMoney * Yii::$app->params['tax_percent'],
            '{total}' => $totalMoney + $totalMoney * Yii::$app->params['tax_percent'],
        ];

        $employee->sendMail($dataSend, $themeEmail);

        return true;
    }

}
