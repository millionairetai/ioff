<?php
namespace member\controllers;

use common\models\Priority;

class PriorityController extends ApiController {
    /*
     * Get priority
     */
    public function actionGetProjectPriority() {
        $objects = [];

        $array = Priority::find()->select(['id', 'name'])->andCompanyId()->all();
        foreach ($array as $item) {
            $objects[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        
        return $this->sendResponse(false, "", $objects);
    }
                 
    public function actionGetPriorityList() {        
        $objects = [];
        $collection = [];

        $priorities = Priority::find()->select(['id','name'])->andCompanyId()->all();
        
        foreach ($priorities as $priority) {
            $collection[] = [
                'id' => $priority->id,
                'name' => $priority->name
            ];
        }
        
        $objects['collection'] = $collection;
        
        return $this->sendResponse(false, "", $objects);
    }
}
