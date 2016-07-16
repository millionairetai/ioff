<?php

namespace member\controllers;

use common\models\Status;

class StatusController extends ApiController {
    
     /**
     * Get status list by company id and column nam
     * 
     * @param integer $projectId 
     * @return boolean|array
     */
    public function actionGetProjectStatus() {
        $objects = [];

        $array = Status::find()->andCompanyId()->andWhere(['column_name' => 'project'])->all();
        foreach ($array as $item) {
            $objects[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        return $this->sendResponse(false, "", $objects);
    }

}
