<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Invoice controller
 */
class InvoiceController extends Controller
{
    public function actionRevenue()
    {
        return $this->render('revenue');
    }
    
    public function actionPaymentHistory()
    {
        return $this->render('payment_history');
    }
    
    public function actionPaymentDetail()
    {
        return $this->render('payment_detail');
    }
}