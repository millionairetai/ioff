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
}
