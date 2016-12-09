<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Translation;
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
        try {
            $controller = \Yii::$app->request->post('Controller');
            if (isset($controller)) {
                $transaction = \Yii::$app->db->beginTransaction();
                //Save into controller table.
                $this->_model->package_id = $controller['package_id'];
                $this->_model->description = $controller['description'];
                $this->_model->url_name = $controller['url_name'];
                $this->_model->package_name = \common\models\Package::findOne($controller['package_id'])->name;
                if ($this->_model->save(false) === false) {
                    throw new \Exception('Can not savecontroller ');
                }
                
                //Save into translation.
                $translation = new Translation();
                $translation->owner_id = $this->_model->id;
                $translation->language_id = $controller['language_id'];
                $translation->owner_table = 'controller';
                $translation->translated_text = $controller['translated_text'];
                if ($translation->save(false) === false) {
                    throw new \Exception('Can not save translation');
                }
                
                $transaction->commit();
                return $this->redirect(['controller/index']);
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
        }
        
        return $this->render('form', ['model' => $this->_model]);
    }

    public function actionUpdate($id) {
        $this->_model = \common\models\Controller::findOne($id);
        $translation = Translation::getByParams(['owner_table' => 'controller', 'owner_id' => $this->_model->id, 'language_id' => $this->_model->id]);
        $this->_model->translated_text = $translation->translated_text;
        $this->_model->language_id = 2;
        
//        var_dump($this->_model->attributes);die;

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
