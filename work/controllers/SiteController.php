<?php
namespace work\controllers;

use Yii;
use common\controllers\CeController;
use common\models\LoginForm;
/**
 * Site controller
 */
class SiteController extends CeController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
