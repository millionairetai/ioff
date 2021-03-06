<?php

namespace member\controllers;

use Yii;
use common\models\Authority;
use common\models\AuthorityAssigment;
use common\models\Employee;

class AuthorityController extends ApiController {

    /**
     * Add one authority
     */
    public function actionAdd() {
        $actions = [];
        $request = \Yii::$app->request->post();

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            if (empty($request)) {
                $this->_error = true;
                return $this->sendResponse($this->_error, 'Request fail', '');
            }
        
            $model = new Authority();
            $model->name = $request['authorityName'];

            if (!$model->save()) {
                $this->_error = true;
                $this->_message = $this->parserMessage($model->getErrors());
                throw new \Exception($this->_message);
            }

            if (!empty($request['actions'])) {
                foreach ($request['actions'] as $controller) {
                    foreach ($controller['actions'] as $action) {
                        if ($action['isChecked']) {
                            $actions[] = [$model->id, $action['id']];
                        }
                    }
                }

                if (!Yii::$app->db->createCommand()->batchInsert(
                                AuthorityAssigment::tableName(), ['authority_id', 'action_id'], $actions)->execute()) {
                    throw new \Exception('BatchInsert to AuthorityAssigment table fail');
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $this->_message = $e->getMessage();
            if (!$this->_error) {
                $this->_error = true;
                $this->_message = \Yii::t('member', 'error_system');
            }

            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }

        return $this->sendResponse($this->_error, $this->_message, $model->name);
    }

    /**
     * Update authority
     */
    public function actionEdit() {
        $actions = [];
        $request = \Yii::$app->request->post();

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            if (!(isset($request['authorityId']) && $request['authorityId'])) {
                throw new \Exception('Request fail');
            }
        
            if (!$model = Authority::findOne($request['authorityId'])) {
                throw new \Exception('Get authority fail');
            }

            $model->name = $request['authorityName'];
            if (!$model->save()) {
                $this->_error = true;
                $this->_message = $this->parserMessage($model->getErrors());
                throw new \Exception($this->_message);
            }

            if (!empty($request['actions'])) {
                if (!AuthorityAssigment::deleteAll('authority_id=' . $model->id)) {
                    throw new \Exception('Delete all authority_assignment fail');
                }

                foreach ($request['actions'] as $controller) {
                    foreach ($controller['actions'] as $action) {
                        if ($action['isChecked']) {
                            $actions[] = [$model->id, $action['id']];
                        }
                    }
                }

                if (!Yii::$app->db->createCommand()->batchInsert(
                                AuthorityAssigment::tableName(), ['authority_id', 'action_id'], $actions)->execute()) {
                    throw new \Exception('BatchInsert to authority_assignment table fail');
                }
            }

            $transaction->commit();
            return $this->sendResponse(false, "", [
                        'id' => $model->id,
                        'name' => $model->name,
                        'firstname' => Yii::$app->user->identity->firstname,
                        'lastname' => Yii::$app->user->identity->lastname,
                        'lastup_datetime' => time(),
                ]
            );
        } catch (\Exception $e) {
            $this->_message = $e->getMessage();

            if (!$this->_error) {
                $this->_error = true;
                $this->_message = \Yii::t('member', 'error_system');
            }

            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }
    }

    /**
     * get list of authority
     */
    public function actionIndex() {
        $request = \Yii::$app->request->get();
        $authorities = Authority::getAll($request, $this->_companyId);

        //Count row.
        $count = Authority::find()->andCompanyId();
        if (isset($request['authorityName']) && $request['authorityName']) {
            $count = $count->andWhere(['like', Authority::tableName() . '.name', $request['authorityName']]);
        }

        //Group together.
        $authorities = [
            'totalItems' => $count->count(),
            'authorities' => $authorities,
        ];

        return $this->sendResponse(false, "", $authorities);
    }

    /**
     * Get all assignment of an authority
     */
    public function actionGetAssignments() {
        $request = \Yii::$app->request->get();
        $assignments = [];

        if (isset($request['authorityId'])) {
            $assignments = AuthorityAssigment::find()
                    ->select('action_id')
                    ->where(['authority_id' => $request['authorityId']])
                    ->andCompanyId()
                    ->asArray()
                    ->all();
        }

        return $this->sendResponse(false, "", $assignments);
    }

    /**
     * Delete an authority
     */
    public function actionDelete() {
        $request = \Yii::$app->request->post();
        $transaction = \Yii::$app->db->beginTransaction();
        
        try {
            if (!$request) {
                throw new \Exception('Request fail');
            }

            if (!$model = Authority::findOne($request['id'])) {
                throw new \Exception('Get authority fail');
            }

            if ($employee = Employee::findOne(['authority_id' => $model->id])) {
                //I use for "is used" for condition in javascrip, so not need to translate
                return $this->sendResponse(true, "is used", [], 422);
            }

            if (!$model->delete()) {
                throw new \Exception('Delete authority fail');
            }
            
            if (!AuthorityAssigment::deleteAll('authority_id=' . $model->id)) {
                throw new \Exception('Delete authority_assigment fail');
            }
            
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_message = $e->getMessage();
            if (!$this->_error) {
                $this->_error = true;
                $this->_message = \Yii::t('member', 'error_system');
            }

            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }
        
        return $this->sendResponse($this->_error, $this->_message, '');
    }
    
}
