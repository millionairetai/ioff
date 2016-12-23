<?php

namespace member\controllers;

use Yii;
use common\models\Authority;
use common\models\AuthorityAssignment;
use common\models\Employee;
use common\models\Controller;

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
                                AuthorityAssignment::tableName(), ['authority_id', 'action_id'], $actions)->execute()) {
                    throw new \Exception('BatchInsert to AuthorityAssignment table fail');
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
                if (!AuthorityAssignment::deleteAll('authority_id=' . $model->id)) {
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
                                AuthorityAssignment::tableName(), ['authority_id', 'action_id'], $actions)->execute()) {
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
            $assignments = AuthorityAssignment::find()
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

            if ($model->delete() === false) {
                throw new \Exception('Delete authority fail');
            }
            
            if (!AuthorityAssignment::deleteAll('authority_id=' . $model->id)) {
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
    
    
    /**
     * Get all of authorities in authority table.
     */
    public function actionGets() {
        $objects = [];
        if ($authorities = Authority::gets(['id', 'name'])) {
            foreach($authorities as $item) {
                $objects[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                ];

            }
        }

        return $this->sendResponse(false, "", $objects);
    }
    
    /**
     * Get all of authorities in authority table.
     */
    public function actionGetEmployeeAuth() {
        $objects = [];
        if ($authorities = Authority::getAuthByEmployeeIdAndIsCheckTrue(Yii::$app->user->identity->id)) {
            foreach($authorities as $key => $val) {
                $objects[$val['controller_column_name']][$val['action_column_name']] = [
                    'url' => $val['url'],
                    'is_display_menu' => $val['is_display_menu'],
                ];

            }
        }

        $objects['is_admin'] = Yii::$app->user->identity->is_admin;
        $objects['user_id'] = Yii::$app->user->identity->id;
        return $this->sendResponse(false, "", $objects);
    }
    
    /**
     * View authority detail
     */
    public function actionView($authorityId) {
        $objects = [];
        try {
            $authorityName = '';
            $controllers = Controller::getTranslation();
            if (empty($controllers)) {
                throw new \Exception;
            }
            
            //Get translated_text of controller via controller id.
            foreach ($controllers as $val) {
                $translation[$val['id']] = $val['translated_text'];
            }

            $authority = Authority::getDetailByAuthorityId($authorityId);
            if (empty($authority)) {
                throw new \Exception;
            }
            foreach($authority as $key => $val) {
                $authorityName = $val['authority_name'];
                $objects[$translation[$val['controller_id']]][] = $val['action_name'];
            }
            
            $objects = ['authorityName' => $authorityName, 'authorities' => $objects];
            return $this->sendResponse(false, "", $objects);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }
}
