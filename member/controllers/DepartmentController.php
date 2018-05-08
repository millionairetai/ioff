<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Department;
use common\models\Employee;

class DepartmentController extends ApiController {

    /**
     * Get all department
     */
    public function actionAll() {
        $objects = [];
        $array = Department::find()->select(['id', 'name'])->andCompanyId()->all();
        foreach ($array as $item) {
            $objects[] = [
                'id' => (int)$item->id,
                'name' => $item->name,
            ];
        }

        return $this->sendResponse(false, "", $objects);
    }

    //Afterward, we will remove actionAll above.
    /**
     * Get all department for select dropdown.
     */
    public function actionGets() {
        $objects = [];
        if ($array = Department::gets(['id', 'name'])) {
            foreach ($array as $item) {
                $objects[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

    //Get an department to edit
    public function actionGet($id) {
        return $this->sendResponse(false, "", Department::getById($id, ['id', 'name', 'description'], false));
    }

    /**
     * Get department list
     */
    public function actionIndex() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        try {
            return $this->sendResponse(false, '', Department::getAll($itemPerPage, $currentPage));
        } catch (\Exception $e) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }

    //Add department
    public function actionAdd() {
        try {
            $request = \Yii::$app->request->post();
            if (!empty($request) && !empty($request['name'])) { 
                $department = Department::getByName($request['name']);
                if (empty($department)) {
                    $department = new Department();
                    $department->name = $request['name'];
                    $department->description = $request['description'];
                    if ($department->save() === false) {
                        $this->_message = $this->parserMessage($department->getErrors());
                        $this->_error = true;
                        throw new \Exception($this->_message);
                    }

                    return $this->sendResponse(false, [], []);
                } else {
                    return $this->sendResponse(true, sprintf(\Yii::t('common', 'error %s is existed'), Yii::t('common', 'department')), []);
                }
            }
        } catch (\Exception $e) {
            $this->_message = \Yii::t('member', 'error_system');
            if ($this->_error == true) {
                $this->_message = $e->getMessage();
            }
            
            return $this->sendResponse(true, $this->_message, []);
        }
    }

    //Update department
    public function actionUpdate() {
        try {
            $request = \Yii::$app->request->post();
            if (!empty($request) && !empty($request['id']) && !empty($request['name'])) {
                $department = Department::getById($request['id'], ['id']);
                if (!empty($department)) {
                    $isExist = Department::isExist($request['id'], $request['name']);
                    if (empty($isExist)) {
                        $department->attributes = $request;
                        if ($department->save() === false) {
                            $this->_message = $this->parserMessage($department->getErrors());
                            $this->_error = true;
                            throw new \Exception($this->_message);
                        }

                        return $this->sendResponse(false, [], []);
                    } else {
                        return $this->sendResponse(true, sprintf(\Yii::t('common', 'error %s is existed'), Yii::t('common', 'department')) , []);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_message = \Yii::t('member', 'error_system');
            if ($this->_error == true) {
                $this->_message = $e->getMessage();
            }
            
            return $this->sendResponse(true, $this->_message, []);
        }
    }
    
    //Delete an department
    public function actionDelete() {
        try {            
            $transaction = \Yii::$app->db->beginTransaction();
            if (!$model = Department::getById(\Yii::$app->request->post('id'))) {
                throw new \Exception('No exist this department');
            }

            if (Employee::getOneByParams(['department_id' => $model->id], ['id']) !== null) {
                return $this->sendResponse(true, "is used", [], 422);
            }

            if ($model->delete() === false) {
                throw new \Exception('Delete department fail');
            }
            
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_error = true;
            $this->_message = \Yii::t('member', 'error_system');
            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }
        
        return $this->sendResponse($this->_error, $this->_message, []);
    }

}
