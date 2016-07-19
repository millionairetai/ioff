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

}
