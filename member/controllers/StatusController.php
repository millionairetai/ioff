<?php

namespace member\controllers;

use common\models\Status;

class StatusController extends ApiController {
    
     /**
     * Get status list by company id and column nam
     */
    public function actionGetProjectStatus() {
        $objects = [];

        $array = Status::find()->select(['id', 'name'])->andWhere(['column_name' => 'project'])->andCompanyId()->all();
        foreach ($array as $item) {
            $objects[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        return $this->sendResponse(false, "", $objects);
    }
    
    public function actionGetTaskStatusList(){                
        $objects = [];       
        $statuses = Status::find()->select(['id','name'])->where(['column_name' => 'task'])->andCompanyId()->all();;
        
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
        $status = Status::getByOwnerTable(\Yii::$app->request->get('type'));
        foreach ($status as $item) {
            $objects[] = [
                'id' => $item['id'],
                'name' => $item['name'],
            ];
        }
        return $this->sendResponse(false, "", $objects);
    }
}
