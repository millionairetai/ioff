<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Language;
use common\models\Action;
use common\models\Status;
use common\models\Priority;
use common\models\Translation;

class TranslationController extends \yii\web\Controller {

    private $_model;
    private $_ownerTable =  [
        'controller' => 'controller', 
        'action' => 'action',
        'plan_type' => 'plan_type',
        'status'    => 'status',
        'priority' => 'priority',
        'event_confirmation_type' => 'event_confirmation_type'
    ];

    public function __construct($id, $module, $config = array()) {
        $this->_model = new \common\models\Translation();
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {
        $dataProvider = $this->_model->search(\Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'model' => $this->_model,
            'dataProvider' => $dataProvider
        ]);
    }

    //Add group of translation for column name from repestive table.
    public function actionAdd() {
        $ownerIds = [];
        $isEmptyTransl = false;
        $controller = \Yii::$app->request->post('Translation');
        if (isset($controller)) {
            if ($ownerTable = $controller['owner_table']) {
                $this->_model->attributes = $controller;   
                switch ($ownerTable) {
                    case 'action':
                        $ownerIds = Action::getControllerPlusAction();
                        break;
                    case 'controller':
                        $ownerIds = \common\models\Controller::gets();
                        break;
                    case 'plan_type':
                        $ownerIds = \common\models\PlanType::gets(['column_name', 'id'], true, true, false);
                        break;
                    case 'status':
                        $ownerIds = \common\models\Status::gets(['column_name', 'id'], true, true, false);
                        break;
                    case 'priority':
                        $ownerIds = \common\models\Priority::gets(['column_name', 'id'], true, true, false);
                        break;
                    case 'event_confirmation_type':
                        $ownerIds = \common\models\EventConfirmationType::gets(['column_name', 'id'], true, true, false);
                        break;
                }
                
                if (!empty($controller['owner_id'])) {
                    $translatedTexts = $controller['translated_text'];
                    $this->_model->translated_text = null;
                    foreach ($translatedTexts as $key => $val) {
                        $this->_model->language_id = $key;
                        $this->_model->translated_text = $val;
                        if (trim($this->_model->translated_text) == '') {
                            $isEmptyTransl = true;
                            Yii::$app->session->setFlash('error', 'Please input text translation all.');
                            
                        }
                        $translaions[] = [
                            'language_id' => $this->_model->language_id,
                            'owner_id' => $this->_model->owner_id,
                            'owner_table' => $this->_model->owner_table,
                            'translated_text' => $this->_model->translated_text,
                        ];
                    }
                    
                    if (empty($isEmptyTransl)) {
                        $transaction = \Yii::$app->db->beginTransaction();
                        if (Translation::batchInsert($translaions) === false) {
                            $transaction->rollBack();
                        }
                    
                        Yii::$app->session->setFlash('success', 'Add translation successfully.');
                        $transaction->commit();
                        return $this->redirect(['translation/index']);
                    }
                }
            }            
        }

        return $this->render('form', [
            'model' => $this->_model, 
            'ownerIds' => $ownerIds,
            'ownerTable' => $this->_ownerTable, 
            'language' => Language::find()->select(['name', 'id'])->indexBy('id')->column()
        ]);
    }

    public function actionUpdate($id) {
        $this->_model = \common\models\Translation::findOne($id);

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
        $this->_model = \common\models\Translation::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->_model->delete()) {
            return $this->redirect(['controller/index']);
        }

        throw new NotFoundHttpException('Can not delete controller');
    }

}
