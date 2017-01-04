<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CompanyController extends \yii\web\Controller {

    private $_model;

    public function __construct($id, $module, $config = array()) {
        $this->_model = new \common\models\Company();
        parent::__construct($id, $module, $config);
    }

    /**
     * Get list of company
     */
    public function actionIndex() {
        $dataProvider = $this->_model->search(\Yii::$app->request->getQueryParams());
        return $this->render('index', ['model' => $this->_model, 'dataProvider' => $dataProvider]);
    }

    /**
     * Add company
     */
    public function actionAdd() {
        $company = \Yii::$app->request->post('Company');
        if (isset($company)) {
            $this->_model->attributes = $company;
            if ($this->_model->save(false)) {
                return $this->redirect(['company/index']);
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    /**
     * Update company
     */
    public function actionUpdate($id) {
        $this->_model = \common\models\Company::findOne($id);
        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $company = \Yii::$app->request->post('Company');
        if (isset($company)) {
            $this->_model->attributes = $company;
            if ($this->_model->save(false)) {
                return $this->redirect(['company/index']);
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    /**
     * Delete company
     */
    public function actionDelete($id) {
        $this->_model = \common\models\Company::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->_model->delete()) {
            return $this->redirect(['company/index']);
        }
        
        throw new NotFoundHttpException('Can not delete company');
    }

     /**
     * report company
     */   
    public function actionReport()
    {
        return $this->render('company_report');
    }

}
