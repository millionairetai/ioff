<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ControllerController extends \yii\web\Controller {

    private $_model;

    public function __construct($id, $module, $config = array()) {
        $this->_model = new \common\models\Controller();
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {
        $dataProvider = $this->_model->search(\Yii::$app->request->getQueryParams());
        return $this->render('index', ['model' => $this->_model, 'dataProvider' => $dataProvider]);
    }

    public function actionAdd() {
            $controller = \Yii::$app->request->post('Controller');
            if (isset($controller)) {
            $this->_model->attributes = $controller;
                $this->_model->package_name = \common\models\Package::findOne($controller['package_id'])->name;
                
            if ($this->_model->save()) {
                return $this->redirect(['controller/index']);
            }
        }
        
        return $this->render('form', ['model' => $this->_model]);
    }

    public function actionUpdate($id) {
        $this->_model = \common\models\Controller::findOne($id);
        
        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $controller = \Yii::$app->request->post('Controller');
        
        if (isset($controller)) {
            $this->_model->attributes = $controller;
            $this->_model->package_name = \common\models\Package::findOne($controller['package_id'])->name;
            
            if ($this->_model->save()) {
                return $this->redirect(['controller/index']);
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    public function actionDelete($id) {
        $this->_model = \common\models\Controller::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->_model->delete()) {
            return $this->redirect(['controller/index']);
        }

        throw new NotFoundHttpException('Can not delete controller');
    }
}
