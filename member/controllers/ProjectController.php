<?php

namespace member\controllers;

use Yii;
use common\models\Project;

class ProjectController extends ApiController{
    
    
    /**
     * 
     * @return type
     */
    public function actionIndex(){
        $error = false;
        $message = "";
        $objects = [];
        //truy xuất db để lấy data
        $data = Project::find()->all();
        foreach($data as $item){
            $objects[] = ['id' => $item->id,'title' => $item->title,'date' => $item->created];
        }
        return $this->sendResponse($error, $message, $objects);
    }
    
    
    /**
     * 
     */
    public function actionAdd(){
        $error = false;
        $message = "";
        $objects = [];
        
        //tạo activerecord, validate dữ liệu
        $ob = new Project();
        $ob->attributes = \Yii::$app->request->post();
        $ob->created = date("Y-m-d H:i:s");
        if(!$ob->save()){
            $message = $this->parserMessage($ob->getErrors());
            $error = true;
        }
        return $this->sendResponse($error, $message, $objects);
    }
    
}