<?php
namespace common\controllers;

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
        if (!Yii::$app->user->isGuest) 
        {
            return $this->redirect('/' . Yii::$app->params['defaultPackage'] . '/web/index.php');
        }

        return $this->redirect('/common/web/index.php?r=site/login');
    }
         
    public function actionLogin()
    {
        $this->layout = 'login';
//        if (!\Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/' . Yii::$app->params['defaultPackage'] . '/web/index.php');
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('/common/web/index.php');
    }
}
