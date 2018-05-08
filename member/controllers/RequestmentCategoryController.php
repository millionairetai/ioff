<?php

namespace member\controllers;

use Yii;
use common\models\RequestmentCategory;

class RequestmentCategoryController extends ApiController {

    //Get requestment category
    public function actionGets() {
        $objects = [];
        if ($array = RequestmentCategory::gets(['id', 'name'])) {
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
        return $this->sendResponse(false, "", RequestmentCategory::getById($id, ['id', 'name', 'description'], false));
    }

    /**
     * Get requestment category list
     */
    public function actionIndex() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        try {
            return $this->sendResponse(false, '', RequestmentCategory::getAll($itemPerPage, $currentPage));
        } catch (\Exception $e) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }

    //Add requestment category
    public function actionAdd() {
        try {
            $request = \Yii::$app->request->post();
            if (!empty($request) && !empty($request['name'])) {
                $requestmentCaterogy = RequestmentCategory::getByName($request['name']);
                if (empty($requestmentCaterogy)) {
                    $requestmentCaterogy = new RequestmentCategory();
                    $requestmentCaterogy->name = $request['name'];
                    $requestmentCaterogy->description = $request['description'];
                    if ($requestmentCaterogy->save() === false) {
                        $this->_message = $this->parserMessage($requestmentCaterogy->getErrors());
                        $this->_error = true;
                        throw new \Exception($this->_message);
                    }

                    return $this->sendResponse(false, [], []);
                } else {
                    return $this->sendResponse(true, sprintf(\Yii::t('common', 'error %s is existed'), Yii::t('member', 'Requestment category')), []);
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

    //Update requestment category
    public function actionUpdate() {
        try {
            $request = \Yii::$app->request->post();
            if (!empty($request) && !empty($request['id']) && !empty($request['name'])) {
                $requestmentCaterogy = RequestmentCategory::getById($request['id'], ['id']);
                if (!empty($requestmentCaterogy)) {
                    $isExist = RequestmentCategory::isExist($request['id'], $request['name']);
                    if (empty($isExist)) {
                        $requestmentCaterogy->attributes = $request;
                        if ($requestmentCaterogy->save() === false) {
                            $this->_message = $this->parserMessage($requestmentCaterogy->getErrors());
                            $this->_error = true;
                            throw new \Exception($this->_message);
                        }

                        return $this->sendResponse(false, [], []);
                    } else {
                        return $this->sendResponse(true, sprintf(\Yii::t('common', 'error %s is existed'), Yii::t('member', 'Requestment category')), []);
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

    //Delete an requestment category
    public function actionDelete() {
        try {
            $transaction = \Yii::$app->db->beginTransaction();
            if (!$model = RequestmentCategory::getById(\Yii::$app->request->post('id'))) {
                throw new \Exception('No exist this requestment category');
            }

//            if (Employee::getOneByParams(['department_id' => $model->id], ['id']) !== null) {
//                return $this->sendResponse(true, "is used", [], 422);
//            }

            if ($model->delete() === false) {
                throw new \Exception('Delete requestment category fail');
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
