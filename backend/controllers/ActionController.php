<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Action;

class ActionController extends \yii\web\Controller {

    private $_model;

    public function __construct($id, $module, $config = array()) {
        $this->_model = new Action();
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {
        $dataProvider = $this->_model->search(\Yii::$app->request->getQueryParams());
        return $this->render('index', ['model' => $this->_model, 'dataProvider' => $dataProvider]);
    }

    public function actionAdd() {
        $action = \Yii::$app->request->post('Action');
        
        if (isset($action)) {
            $this->_model->attributes = $action;
            
            if ($this->_model->save()) {
                return $this->redirect(['action/index']);
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    public function actionUpdate($id) {
        $this->_model = Action::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $action = \Yii::$app->request->post('Action');
        
        if (isset($action)) {
            $this->_model->attributes = $action;
            
            if ($this->_model->save()) {
                return $this->redirect(['action/index']);
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    public function actionDelete($id) {
        $this->_model = Action::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->_model->delete()) {
            return $this->redirect(['action/index']);
        }

        throw new NotFoundHttpException('Can not delete controller');
    }
}
