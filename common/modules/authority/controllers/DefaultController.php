<?php

namespace common\modules\authority\controllers;

use yii\web\Controller;
use common\controllers\CeController;

class DefaultController extends CeController
{
    public function actionIndex()
    {
        return $this->redirect('authority/authority/');
//        return $this->render('index');
    }
    
    public function actionTest()
    {
        return $this->render('index');
    }
}
