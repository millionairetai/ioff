<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StaffController extends \yii\web\Controller {

    private $_model;

    public function __construct($id, $module, $config = array()) {
        $this->_model = new \common\models\Staff();
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {
        $dataProvider = $this->_model->search(\Yii::$app->request->getQueryParams());
        return $this->render('index', ['model' => $this->_model, 'dataProvider' => $dataProvider]);
    }

    public function actionAdd() {
        $staff = \Yii::$app->request->post('Staff');

        if (isset($staff)) {
            $this->_model->attributes = $staff;
//            $this->_model->package_name = \common\models\Package::findOne($staff['package_id'])->name;

            if ($this->_model->save()) {
                return $this->redirect(['staff/index']);
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    public function actionUpdate($id) {
        $this->_model = \common\models\Staff::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $staff = \Yii::$app->request->post('Staff');

        if (isset($staff)) {
            $this->_model->attributes = $staff;
//            $this->_model->package_name = \common\models\Package::findOne($staff['package_id'])->name;

            if ($this->_model->save()) {
                return $this->redirect(['staff/index']);
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    public function actionDelete($id) {
        $this->_model = \common\models\Staff::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->_model->delete()) {
            return $this->redirect(['staff/index']);
        }

        throw new NotFoundHttpException('Can not delete staff');
    }

}
