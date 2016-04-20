<?php
namespace member\controllers;
use common\models\Status;

class StatusController extends ApiController{
    
    /*
     * 
     */

    public function actionProject() {
        $error = false;
        $message = "";
        $objects = [];

        $array = Status::find()->andWhere(['column_name' => 'project'])->all();
        foreach ($array as $item) {
            $objects[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        return $this->sendResponse($error, $message, $objects);
    }
}