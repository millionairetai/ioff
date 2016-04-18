<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Department;

class DepartmentController extends ApiController {
    
    public function actionShow() {
        
    }
    
    
    /**
     * 
     */
    public function actionAll(){
        $error = false;
        $message = "";
        $objects = [];
        $array = Department::find()->andCompanyId()->all();
        foreach($array as $item){
            $objects[] = [
                'id' => $item->id,
                'name' => $item->name,
            ];
        }
        return $this->sendResponse($error, $message, $objects);
    }
}