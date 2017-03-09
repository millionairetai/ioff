<?php

namespace member\controllers;

use Yii;
use common\models\Order;
use common\models\PlanType;
use common\components\web\IoffDateTime;

class OrderController extends ApiController {

    /**
     * Get order history
     */
    public function actionGetHistory() {
        $orders = [];
        try {
            $result = Order::getsByCompanyId(Yii::$app->user->identity->company_id);
            if (empty($result)) {
                throw new \Exception;
            }

            foreach ($result as $order) {
                $orders[] = [
                    'id' => $order['id'],
                    'datetime_created' => \Yii::$app->formatter->asDate($order['datetime_created']),
                    'plan_type_name' => $order['plan_type_name'], 
                    'plan_type_column_name' => $order['plan_type_column_name'],
                    'number_month' => $order['number_month'], 
                    'description' => sprintf(Yii::t('common', 'description invoice'),
                            $order['plan_type_name'], 
                            !empty($order['max_user_register']) ? $order['max_user_register'] : Yii::t('common', 'Unlimited'), 
                            $order['max_storage_register'],
                            !empty($order['number_month']) ? $order['number_month'] : strtolower(Yii::t('common', 'Unlimited'))
                        ),
                    'status_column_name' => $order['status_column_name']
                ];
            }
            
            return $this->sendResponse(false, "", ['orders' => $orders,]);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }
    
        /**
     * Get order history
     */
    public function actionGetOrderDetail($orderId) {
        $order = [];
        $totalMoney = 0;
        try {
            $result = Order::getOrderInfoById($orderId);
            if (empty($result)) {
                throw new \Exception;
            }
            
            $planType = PlanType::getsIndexById();
            if (empty($planType)) {
                return $this->redirect('/order/index');
            }

            //Get total money.
            switch ($result['plan_type_column_name']) {
                case 'free':
                    $totalMoney = 0;
                    break;
                case 'standard':
                    $totalMoney = ($planType[$result['plan_type_id']]['fee_user'] * $result['max_user_register'] + $planType[$result['plan_type_id']]['fee_storage'] * $result['max_storage_register']) * $result['number_month'];
                    break;
                case 'premium':
                    $totalMoney = ($planType[$result['plan_type_id']]['fee_user'] + $planType[$result['plan_type_id']]['fee_storage'] * $result['max_storage_register']) * $result['number_month'];
                    break;
            }

            $order = [
                    'id' => $result['id'],
                    'datetime_created' => Yii::$app->formatter->asDate($result['order_datetime_created']),
                    'service_from' => Yii::$app->params['service_from'],
                    'address_from' => Yii::$app->params['address_from'],
                    'phone_from' => Yii::$app->params['phone_from'],
                    'email_from' => Yii::$app->params['email_from'],
                    'company_name_to' => $result['company_name'],
                    'company_address_to' => $result['employee_street_address_1'],
                    'company_phone_to' => $result['company_phone_no'],
                    'email_to' => $result['employee_email'],
        //            'invoice_no' => $invoiceOrderNo['invoiceNo'],
                    'order_no' => $result['order_number'],
                    'account' => $result['employee_email'],
                    'product_name' => $result['plan_type_name'],
                    'description' => sprintf(Yii::t('common', 'description invoice'), $result['plan_type_name'], 
                            !empty($result['max_user_register']) ? $result['max_user_register'] : strtolower(Yii::t('common', 'Unlimited')), 
                            $result['max_storage_register'], 
                            !empty($result['number_month']) ? $result['number_month'] : strtolower(Yii::t('common', 'Unlimited'))
                        ),
                    'subtotal' => $totalMoney,
                    'payment_method' => Yii::t('common', 'Bank transfer'),
                    'tax_percent' => Yii::$app->params['tax_percent'],
                    'total_tax' => $totalMoney * Yii::$app->params['tax_percent'],
                    'final_total_money' => $totalMoney + $totalMoney * Yii::$app->params['tax_percent'],
                    'is_wait_pay' => empty($invoice) ? $result['status_column_name'] == Order::COLUNM_NAME_WAIT_PAY : false,
                    'is_payed' => empty($invoice) ? $result['status_column_name'] == Order::COLUNM_NAME_PAYED : false,
                ];
            
            return $this->sendResponse(false, "", ['order' => $order,]);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }


}
