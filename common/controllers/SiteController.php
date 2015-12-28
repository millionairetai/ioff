<?php

namespace common\controllers;

use Yii;
use common\controllers\CeController;
use common\models\LoginForm;

/**
 * Index controller
 */
class SiteController extends CeController
{    
    public function actionIndex()
    {
        return $this->redirect('/' . Yii::$app->params['defaultPackage'] . '/web/index.php');
    }
         
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

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
