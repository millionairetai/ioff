<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Invoice;
use common\models\Company;

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

    public function actionPaymentHistory() {
        return $this->render('payment_history');
    }

    public function actionPaymentDetail() {
        return $this->render('payment_detail');
    }

}
