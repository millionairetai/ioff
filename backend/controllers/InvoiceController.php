<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Invoice;
use common\models\Company;
use common\models\PlanType;
use common\components\web\IoffDateTime;

/**
 * Invoice controller
 */
class InvoiceController extends Controller {

    public function actionRevenue() {
        $previousMonthRevenue = Invoice::getPreviousMonthRevenue();
        $data['total_revenue_in_month'] = Invoice::getRevenueInMonth();
        $data['increase_percent'] = Yii::$app->formatter->asPercent(
                ($data['total_revenue_in_month'] - $previousMonthRevenue) / ($data['total_revenue_in_month']));

        $company = Company::getCompanyEachPlanType();
        $data['total_free_company'] = !empty($company['free']['total']) ? $company['free']['total'] : 0;
        $data['total_standard_company'] = !empty($company['standard']['total']) ? $company['standard']['total'] : 0;
        $data['total_premium_company'] = !empty($company['premium']['total']) ? $company['premium']['total'] : 0;
        $data['total_revenue_in_month'] = Yii::$app->formatter->asCurrency(Invoice::getRevenueInMonth());
        $data['total_company'] = $data['total_free_company'] + $data['total_standard_company'] + $data['total_premium_company'];

        $data['invoice_each_plan_type'] = Invoice::getTotalRevenueEachPlanType();
        $data['company_each_plan_type'] = Company::getCompanyEachPlanType();
        $data['invoice_each_plan_type']['standard']['total_company'] = $data['company_each_plan_type']['standard']['total'];
        $data['invoice_each_plan_type']['premium']['total_company'] = $data['company_each_plan_type']['premium']['total'];

        $data['invoice_each_plan_type']['standard']['total_money'] = Yii::$app->formatter->asCurrency($data['invoice_each_plan_type']['standard']['total_money']);
        $data['invoice_each_plan_type']['premium']['total_money'] = Yii::$app->formatter->asCurrency($data['invoice_each_plan_type']['premium']['total_money']);

        return $this->render('revenue', ['data' => $data]);
    }

    //Get payment history.
    public function actionPaymentHistory($id) {
        $invoices = [];
        $result = Invoice::getsByCompanyId($id);
        if (!empty($result)) {
            foreach ($result as $invoice) {
                $invoices[] = [
                    'id' => $invoice['id'],
                    'datetime_created' => \Yii::$app->formatter->asDate($invoice['datetime_created']),
                    'plan_type_name' => $invoice['plan_type_name'],
                    'plan_type_column_name' => $invoice['plan_type_column_name'],
                    'number_month' => $invoice['number_month'],
                    'description' => sprintf(Yii::t('common', 'description invoice'), $invoice['plan_type_name'], !empty($invoice['max_user_register']) ? $invoice['max_user_register'] : Yii::t('common', 'Unlimited'), $invoice['max_storage_register'], !empty($invoice['number_month']) ? $invoice['number_month'] : strtolower(Yii::t('common', 'Unlimited'))
                    ),
                    'status_column_name' => $invoice['status_column_name']
                ];
            }
        }
        
        return $this->render('payment_history', ['invoices' => $invoices, 'companyId' => $id]);
    }
    
    //Get invoice detail
    public function actionDetail($invoiceId, $companyId) {
        $planType = PlanType::getsIndexById();
        if (empty($planType)) {
            return $this->redirect('/order/index');
        }
        
        if (!$invoiceInfo = Invoice::getById($invoiceId)) {
            return $this->redirect('/order/index');
        }

        //Get total money.
        switch ($invoiceInfo['plan_type_column_name']) {
            case 'free':
                $totalMoney = 0;
                break;
            case 'standard':
                $totalMoney = ($planType[$invoiceInfo['plan_type_id']]['fee_user'] * $invoiceInfo['max_user_register'] + $planType[$invoiceInfo['plan_type_id']]['fee_storage'] * $invoiceInfo['max_storage_register']) * $invoiceInfo['number_month'];
                break;
            case 'premium':
                $totalMoney = ($planType[$invoiceInfo['plan_type_id']]['fee_user'] + $planType[$invoiceInfo['plan_type_id']]['fee_storage'] * $invoiceInfo['max_storage_register']) * $invoiceInfo['number_month'];
                break;
        }

        $employee = new \common\models\Employee();
        $employee->firstname = $invoiceInfo['employee_firstname'];
        $employee->lastname = $invoiceInfo['employee_lastname'];
        $invoiceInfo = [
            'date_invoice' => Yii::$app->formatter->asDate(IoffDatetime::getDate()),
            'service_from' => Yii::$app->params['service_from'],
            'address_from' => Yii::$app->params['address_from'],
            'phone_from' => Yii::$app->params['phone_from'],
            'email_from' => Yii::$app->params['email_from'],
            'company_name_to' => $invoiceInfo['company_name'],
            'address_to' => $invoiceInfo['employee_street_address_1'],
            'commpany_phone_to' => $invoiceInfo['company_phone_no'],
            'email_to' => $invoiceInfo['employee_email'],
//            'invoice_no' => $invoiceOrderNo['invoiceNo'],
            'invoice_no' => $invoiceInfo['invoice_number'],
            'account' => $invoiceInfo['employee_email'],
            'product_name' => $invoiceInfo['plan_type_name'],
            'description' => sprintf(Yii::t('common', 'description invoice'), $invoiceInfo['plan_type_name'], 
                    !empty($invoiceInfo['max_user_register']) ? $invoiceInfo['max_user_register'] : strtolower(Yii::t('common', 'Unlimited')), 
                    $invoiceInfo['max_storage_register'], 
                    !empty($invoiceInfo['number_month']) ? $invoiceInfo['number_month'] : strtolower(Yii::t('common', 'Unlimited'))
                ),
            'subtotal' => $totalMoney,
            'payment_method' => Yii::t('common', 'Bank transfer'),
            'tax_percent' => Yii::$app->params['tax_percent'],
            'total_tax' => $totalMoney * Yii::$app->params['tax_percent'],
            'total' => $totalMoney + $totalMoney * Yii::$app->params['tax_percent'],
            'is_wait_pay' => empty($invoice) ? $invoiceInfo['status_column_name'] == Invoice::COLUNM_NAME_WAIT_PAY : false,
            'is_payed' => empty($invoice) ? $invoiceInfo['status_column_name'] == Invoice::COLUNM_NAME_PAYED : false,
        ];

        return $this->render('invoice_detail', ['invoiceInfo' => $invoiceInfo, 'companyId' => $companyId]);
    }

}
