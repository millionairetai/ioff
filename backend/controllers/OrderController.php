<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Order;
use common\models\OrderItem;
use common\models\Invoice;
use common\models\InvoiceDetail;
use common\components\web\IoffDatetime;
use common\models\PlanType;
use common\models\Status;
use common\models\Company;
use common\models\EmailTemplate;
use common\models\Employee;
use common\models\PaymentMethod;

class OrderController extends \yii\web\Controller {

    private $_model;

    public function __construct($id, $module, $config = array()) {
        $this->_model = new Order();
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {
        $dataProvider = $this->_model->search(\Yii::$app->request->getQueryParams());
        return $this->render('index', ['model' => $this->_model, 'dataProvider' => $dataProvider]);
    }

    //View order to complete for order.
    public function actionView($id) {
        $planType = PlanType::getsIndexById();
        if (empty($planType)) {
            return $this->redirect('/order/index');
        }
        
        if (!$orderInfo = Order::getOrderInfoById($id)) {
            return $this->redirect('/order/index');
        }

        //Get total money.
        switch ($orderInfo['plan_type_column_name']) {
            case 'free':
                $totalMoney = 0;
                break;
            case 'standard':
                $totalMoney = ($planType[$orderInfo['plan_type_id']]['fee_user'] * $orderInfo['max_user_register'] + $planType[$orderInfo['plan_type_id']]['fee_storage'] * $orderInfo['max_storage_register']) * $orderInfo['number_month'];
                break;
            case 'premium':
                $totalMoney = ($planType[$orderInfo['plan_type_id']]['fee_user'] + $planType[$orderInfo['plan_type_id']]['fee_storage'] * $orderInfo['max_storage_register']) * $orderInfo['number_month'];
                break;
        }
        
        //Complete order if staff request.
        if (Yii::$app->request->post()) {
            try {
                $transaction = \Yii::$app->db->beginTransaction();
                if ($invoice = $this->_completeOrder($orderInfo, $planType, $totalMoney)) {
                    $this->_sendInvoiceEmail($orderInfo, $planType, $invoice);
                    Yii::$app->session->setFlash('success', Yii::t('backend', 'Complete order sucessfully'));
                }

                $transaction->commit();
            } catch (\Exception $ex) {
                $transaction->rollBack();
                return false;
            }
        }

        $employee = new \common\models\Employee();
        $employee->firstname = $orderInfo['employee_firstname'];
        $employee->lastname = $orderInfo['employee_lastname'];
        $invoiceInfo = [
            'id' => $id,
            'date_invoice' => Yii::$app->formatter->asDate(IoffDatetime::getDate()),
            'service_from' => Yii::$app->params['service_from'],
            'address_from' => Yii::$app->params['address_from'],
            'phone_from' => Yii::$app->params['phone_from'],
            'email_from' => Yii::$app->params['email_from'],
            'fullname_to' => $employee->fullname,
            'address_to' => $orderInfo['employee_street_address_1'],
            'phone_to' => $orderInfo['employee_mobile_phone'],
            'email_to' => $orderInfo['employee_email'],
//            'invoice_no' => $invoiceOrderNo['invoiceNo'],
            'order_no' => $orderInfo['order_number'],
            'account' => $orderInfo['employee_email'],
            'product_name' => $orderInfo['plan_type_name'],
            'description' => sprintf(Yii::t('common', 'description invoice'), $orderInfo['plan_type_name'], 
                    !empty($orderInfo['max_user_register']) ? $orderInfo['max_user_register'] : strtolower(Yii::t('common', 'Unlimited')), 
                    $orderInfo['max_storage_register'], 
                    !empty($orderInfo['number_month']) ? $orderInfo['number_month'] : strtolower(Yii::t('common', 'Unlimited'))
                ),
            'subtotal' => $totalMoney,
            'payment_method' => Yii::t('common', 'Bank transfer'),
            'tax_percent' => Yii::$app->params['tax_percent'],
            'total_tax' => $totalMoney * Yii::$app->params['tax_percent'],
            'total' => $totalMoney + $totalMoney * Yii::$app->params['tax_percent'],
            'is_wait_pay' => empty($invoice) ? $orderInfo['status_column_name'] == Order::COLUNM_NAME_WAIT_PAY : false,
            'is_payed' => empty($invoice) ? $orderInfo['status_column_name'] == Order::COLUNM_NAME_PAYED : false,
        ];

        return $this->render('view', ['invoiceInfo' => $invoiceInfo]);
    }

    //Print order.
    public function actionPrint($id) {
        $planType = PlanType::getsIndexById();
        if (empty($planType)) {
            return $this->redirect('/order/index');
        }
        
        if (!$orderInfo = Order::getOrderInfoById($id)) {
            return $this->redirect('/order/index');
        }

        //Get total money.
        switch ($orderInfo['plan_type_column_name']) {
            case 'free':
                $totalMoney = 0;
                break;
            case 'standard':
                $totalMoney = ($planType[$orderInfo['plan_type_id']]['fee_user'] * $orderInfo['max_user_register'] + $planType[$orderInfo['plan_type_id']]['fee_storage'] * $orderInfo['max_storage_register']) * $orderInfo['number_month'];
                break;
            case 'premium':
                $totalMoney = ($planType[$orderInfo['plan_type_id']]['fee_user'] + $planType[$orderInfo['plan_type_id']]['fee_storage'] * $orderInfo['max_storage_register']) * $orderInfo['number_month'];
                break;
        }
        
        //Complete order if staff request.
        if (Yii::$app->request->post()) {
            try {
                $transaction = \Yii::$app->db->beginTransaction();
                if ($invoice = $this->_completeOrder($orderInfo, $planType, $totalMoney)) {
                    $this->_sendInvoiceEmail($orderInfo, $planType, $invoice);
                    Yii::$app->session->setFlash('success', Yii::t('backend', 'Complete order sucessfully'));
                }

                $transaction->commit();
            } catch (\Exception $ex) {
                $transaction->rollBack();
                return false;
            }
        }

        $employee = new \common\models\Employee();
        $employee->firstname = $orderInfo['employee_firstname'];
        $employee->lastname = $orderInfo['employee_lastname'];
        $invoiceInfo = [
            'date_invoice' => Yii::$app->formatter->asDate(IoffDatetime::getDate()),
            'service_from' => Yii::$app->params['service_from'],
            'address_from' => Yii::$app->params['address_from'],
            'phone_from' => Yii::$app->params['phone_from'],
            'email_from' => Yii::$app->params['email_from'],
            'fullname_to' => $employee->fullname,
            'address_to' => $orderInfo['employee_street_address_1'],
            'phone_to' => $orderInfo['employee_mobile_phone'],
            'email_to' => $orderInfo['employee_email'],
//            'invoice_no' => $invoiceOrderNo['invoiceNo'],
            'order_no' => $orderInfo['order_number'],
            'account' => $orderInfo['employee_email'],
            'product_name' => $orderInfo['plan_type_name'],
            'description' => sprintf(Yii::t('common', 'description invoice'), $orderInfo['plan_type_name'], 
                    !empty($orderInfo['max_user_register']) ? $orderInfo['max_user_register'] : strtolower(Yii::t('common', 'Unlimited')), 
                    $orderInfo['max_storage_register'], 
                    !empty($orderInfo['number_month']) ? $orderInfo['number_month'] : strtolower(Yii::t('common', 'Unlimited'))
                ),
            'subtotal' => $totalMoney,
            'payment_method' => Yii::t('common', 'Bank transfer'),
            'tax_percent' => Yii::$app->params['tax_percent'],
            'total_tax' => $totalMoney * Yii::$app->params['tax_percent'],
            'total' => $totalMoney + $totalMoney * Yii::$app->params['tax_percent'],
            'is_wait_pay' => empty($invoice) ? $orderInfo['status_column_name'] == Order::COLUNM_NAME_WAIT_PAY : false,
            'is_payed' => empty($invoice) ? $orderInfo['status_column_name'] == Order::COLUNM_NAME_PAYED : false,
        ];

        return $this->render('print', ['invoiceInfo' => $invoiceInfo]);
    }

    /**
     *  Insert invoice for complete order.
     *  @param object $orderInfo
     *  @param object $totalMoney
     *  @param object $planType
     * 
     *  @return Active Record.
     */
    private function _completeOrder($orderInfo, $planType, $totalMoney) {
        if (!$order = Order::getById($orderInfo['id'], ['*'], true, false)) {
            throw new \Exception('Can not get order by id');
        }
        
        //Get status for order.
        $status = Status::getByOwnerTableAndColumnName('order', Order::COLUNM_NAME_PAYED);
        $order->status_id = $status['id'];
        if ($order->save(false) === false) {
            throw new \Exception('Save data to order table fail');
        }

        $invoice = new Invoice();
        $invoice->company_id = $orderInfo['company_id'];
        $invoice->invoice_number = time();
        //Get status of employee which is active.
        if (!$status = Status::getByOwnerTableAndColumnName('invoice', Invoice::COLUNM_NAME_PAYED)) {
            throw new \Exception('Can not get status');
        }
        
        $invoice->status_id = $status['id'];
        $invoice->order_id = $order->id;
        $invoice->staff_id = Yii::$app->user->identity->id;
        $invoice->employee_id = $orderInfo['employee_id'];
        $invoice->total_money = $totalMoney;
        if (!$paymentMethod = PaymentMethod::getByName('Bank transfer', false, false)) {
            throw new \Exception('Can not get payment method');
        }
        
        $invoice->payment_method_id = $paymentMethod['id'];
        $invoice->expired_datetime = strtotime(IoffDatetime::getDate() . ' +' . $orderInfo['number_month'] . ' month');
        if ($invoice->save(false) === false) {
            throw new \Exception('Save data to invoice table fail');
        }

        $invoiceDetail = new InvoiceDetail();
        $invoiceDetail->company_id = $orderInfo['company_id'];
        $invoiceDetail->invoice_id = $invoice->id;
        $invoiceDetail->number_month = $orderInfo['number_month'];
        $invoiceDetail->plan_type_id = $orderInfo['plan_type_id'];
        $invoiceDetail->max_user_register = $orderInfo['max_user_register'];
        $invoiceDetail->max_storage_register = $orderInfo['max_storage_register'];
        if ($invoiceDetail->save(false) === false) {
            throw new \Exception('Save data to invoice detail table fail');
        }

        //Update max user and max storage in company table.
        $company = new Company();
        $company->updateByArr([
                'max_user_register' => $orderInfo['max_user_register'],
                'max_storage_register' => $orderInfo['max_storage_register'],
                'plan_type_id' => $orderInfo['plan_type_id'],
                'start_date' => IoffDatetime::getTimestamp(),
                'expired_date' => strtotime(IoffDatetime::getDate() . ' +' . $orderInfo['number_month'] . ' month')
            ], 
            $orderInfo['company_id']
        );

        return $invoice;
    }

    /**
     *  Send invoice email for complete order.
     *  @param array $orderInfo
     *  @param array $planType
     *  @param object $invoice
     *  @return boolean
     */
    private function _sendInvoiceEmail($orderInfo, $planType, $invoice) {
        $themeEmail = EmailTemplate::getTheme(EmailTemplate::COMPANY_PAYMENT_INVOICE);
        $employee = new Employee();
        $employee->firstname = $orderInfo['employee_firstname'];
        $employee->lastname = $orderInfo['employee_lastname'];
        $employee->email = $orderInfo['employee_email'];
        $dataSend = [
            '{date invoice}' => Yii::$app->formatter->asDate(IoffDatetime::getTimestamp()),
            '{service from}' => Yii::$app->params['service_from'],
            '{address from}' => Yii::$app->params['address_from'],
            '{phone from}' => Yii::$app->params['phone_from'],
            '{email from}' => Yii::$app->params['email_from'],
            '{fullname to}' => $employee->fullname,
            '{address to}' => $orderInfo['employee_street_address_1'],
            '{phone to}' => $orderInfo['employee_mobile_phone'],
            '{email to}' => $orderInfo['employee_email'],
            '{invoice no}' => $invoice->invoice_number,
            '{order no}' => $orderInfo['order_number'],
            '{account}' => $orderInfo['employee_email'],
            '{product name}' => $orderInfo['plan_type_name'],
            '{description}' => sprintf(Yii::t('common', 'description invoice'), $orderInfo['plan_type_name'], 
                    !empty($orderInfo['max_user_register']) ? $orderInfo['max_user_register'] : Yii::t('common', 'Unlimited'), 
                    $orderInfo['max_storage_register'], 
                    !empty($orderInfo['number_month']) ? $orderInfo['number_month'] : Yii::t('common', 'Unlimited')),
            '{subtotal}' => $invoice->total_money,
            '{payment method}' => Yii::t('common', 'Bank transfer'),
            '{tax percent}' => Yii::$app->params['tax_percent'],
            '{total tax}' => $invoice->total_money * Yii::$app->params['tax_percent'],
            '{total}' => $invoice->total_money + $invoice->total_money* Yii::$app->params['tax_percent'],
        ];

        $employee->sendMail($dataSend, $themeEmail);

        return true;
    }

}
