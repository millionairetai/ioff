<?php

namespace member\controllers;

use Yii;

class ApiController extends CommonController{
    
    /**
     * 
     * @param type $action
     * @return type
     */
    public function beforeAction($action) {
        if(Yii::$app->user->isGuest){
            $this->sendResponse(true, "", [],203);
        }
        return parent::beforeAction($action);
    }
    
}