<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Company;

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
    public function actionReport() {
        $data = [];
        //Get info company.
        $company = Company::getCompanyEachPlanType();
        $data['total_free_company'] = !empty($company['free']['total']) ? $company['free']['total'] : 0;
        $data['total_standard_company'] = !empty($company['standard']['total']) ? $company['standard']['total'] : 0;
        $data['total_premium_company'] = !empty($company['premium']['total']) ? $company['premium']['total'] : 0;
        $data['total_company'] = $data['total_free_company'] + $data['total_standard_company'] + $data['total_premium_company'];
        
        //Get total size of database iofficez.
        $data['total_disk'] = Yii::$app->params['total_disk'];
        $db = Yii::$app->getDb();
        $dbName = $this->_getDsnAttribute('dbname', $db->dsn);
        $data['used_storage_database'] = Company::getTotalDatabaseSize($dbName);
        $data['used_storage_database'] = $data['used_storage_database'][0]['db_size'];
        $data['used_storage_file'] = Yii::$app->formatter->asDecimal(Company::getSumTotalStorage() / 1048576, 2);
        $data['total_used_storage'] = Yii::$app->formatter->asDecimal($data['used_storage_database'] + $data['used_storage_file'], 2);
        $data['percent_used_storage'] = Yii::$app->formatter->asPercent($data['used_storage_database'] + $data['used_storage_file']) / Yii::$app->params['total_disk'];
        $data['percent_used_storage'] = Yii::$app->formatter->asDecimal(($data['used_storage_database'] + $data['used_storage_file']) / Yii::$app->params['total_disk']);
        
        $companyChart = [];
        $companyChart['data'] = [];
        $companyChart['labels'] = [];
        if ($companyOverMonths = Company::getRegisterOverMonth()) {
            foreach ($companyOverMonths as $companyOverMonth) {
                $companyChart['data'][] = $companyOverMonth['quantity'];
                $companyChart['labels'][] = $companyOverMonth['month'];
            }
        }

        $report = [
            'company' => $data,
            'chart' => [
                'labels' => json_encode($companyChart['labels']),
                'data' =>
                    json_encode($companyChart['data'])
            ]
        ];

        return $this->render('company_report', ['report' => $report]);
    }
    
    
    private function _getDsnAttribute($name, $dsn) {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

}
