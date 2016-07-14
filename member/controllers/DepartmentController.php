<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Department;

class DepartmentController extends ApiController {

    /**
     * Get all department
     */
    public function actionAll() {
        $objects = [];
        if ($array = Department::find()->andCompanyId()->all()) {
            foreach ($array as $item) {
                $objects[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

}
