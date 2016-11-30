<?php

namespace member\controllers;

use common\models\Status;
use common\models\Employee;

class StatusController extends ApiController {

    /**
     * Get status list by company id and column nam
     */
    public function actionGetProjectStatus() {
        $objects = [];

        $array = Status::find()->select(['id', 'name'])->andWhere(['owner_table' => 'project'])->andCompanyId()->all();
        foreach ($array as $item) {
            $objects[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        return $this->sendResponse(false, "", $objects);
    }

    public function actionGetTaskStatusList() {
        $objects = [];
        $statuses = Status::find()->select(['id', 'name'])->where(['owner_table' => 'task'])->andCompanyId()->all();
        $collection = [];

        foreach ($statuses as $status) {
            $collection[] = [
                'id' => $status->id,
                'name' => $status->name
            ];
        }

        $objects['collection'] = $collection;

        return $this->sendResponse(false, "", $objects);
    }

    /**
     * Get status list by owner table
     */
    public function actionGetStatus() {
        $objects = [];
        if ($status = Status::getByOwnerTable(\Yii::$app->request->get('type'))) {
            foreach ($status as $item) {
                $objects[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

    //Get employee status by current employee status
    public function actionGetEmployeeStatuses() {
        $objects = [];
        if ($status = Status::getEmployeesStatus()) {
            if ($currentStatusId = \Yii::$app->request->get('currentStatus')) {
                $currStatusColumnName = $status[$currentStatusId]['column_name'];
                foreach ($status as $item) {
                    if ($currStatusColumnName == Employee::COLUNM_NAME_ACTIVE && $item['column_name'] == Employee::COLUNM_NAME_INVITED)
                        continue;
                    if ($currStatusColumnName == Employee::COLUNM_NAME_INACTIVE && $item['column_name'] == Employee::COLUNM_NAME_INVITED)
                        continue;
                    if ($currStatusColumnName == Employee::COLUNM_NAME_INVITED && $item['column_name'] != Employee::COLUNM_NAME_INVITED)
                        continue;

                    $objects[] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                    ];
                }
            } else {
                foreach ($status as $item) {
                    if ($item['column_name'] != Employee::COLUNM_NAME_ACTIVE)
                        continue;
                    $objects[] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                    ];
                }
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

}
