<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Action;
use common\models\Translation;

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
        try {
            $action = \Yii::$app->request->post('Action');
            if (isset($action)) {
                $transaction = \Yii::$app->db->beginTransaction();
                //Save into controller table.
                $this->_model->controller_id = $action['controller_id'];
                $this->_model->description = $action['description'];
                $this->_model->column_name = $action['column_name'];
                $this->_model->url = $action['url'];
                $this->_model->is_display_menu = 1;
                $this->_model->is_check = 1;
                if ($this->_model->save(false) === false) {
                    throw new \Exception('Can not savecontroller ');
                }
                
                //Save into translation.
                $translation = new Translation();
                $translation->owner_id = $this->_model->id;
                $translation->language_id = $action['language_id'];
                $translation->owner_table = 'action';
                $translation->translated_text = $action['translated_text'];
                if ($translation->save(false) === false) {
                    throw new \Exception('Can not save translation');
                }
                
                $transaction->commit();
                return $this->redirect(['action/index']);
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
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
