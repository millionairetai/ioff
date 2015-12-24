<?php
namespace work\controllers;

use Yii;
use common\controllers\CommonController;
use common\models\LoginForm;
/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
