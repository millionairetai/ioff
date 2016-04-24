<?php
namespace member\controllers;

use common\models\Priority;

class PriorityController extends ApiController{
    
    /*
     * get priority
     */
    public function actionIndex() {
        $error = false;
        $message = "";
        $objects = [];

        $array = Priority::find()->andCompanyId()->all();
        foreach ($array as $item) {
            $objects[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        return $this->sendResponse($error, $message, $objects);
    }
}