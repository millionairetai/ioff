<?php
namespace kpi\controllers;

use Yii;
use common\models\LoginForm;
use kpi\models\PasswordResetRequestForm;
use kpi\models\ResetPasswordForm;
use kpi\models\SignupForm;
use kpi\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\controllers\CommonController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
