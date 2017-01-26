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

}
