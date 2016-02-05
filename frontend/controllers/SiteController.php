<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\LoginForm;
/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTest() 
    {
        
    }
}
