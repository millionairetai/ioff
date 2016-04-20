<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Employee;

class EmployeeController extends ApiController {
    
    public function actionShow() {
        
    }
    
    
    /**
     * search employee
     */
    public function actionSearch(){
        $error = false;
        $message = "";
        $objects = [];
        $keyword = Yii::$app->request->post('keyword');
        $departments = Yii::$app->request->post('departments',[]);
        $members = Yii::$app->request->post('members',[]);
        $manager = Yii::$app->request->post('manager',[]);
        $query = Employee::find()->andCompanyId()->andWhere(['like','firstname',$keyword]);
        
        //check department
        if(count($departments)){
           $query->andWhere(['not in','department_id',$departments]) ;
        }
        
        //check manager
        if(isset($manager['id'])){
           $query->andWhere(['!=','id',$manager['id']]) ;
        }
        
        //check member
        if(count($members)){
            $ids = [];
            foreach ($members as $mb){
                $ids[] = $mb['id'];
            }
           $query->andWhere(['not in','id',$ids]) ;
        }
        
        $employees = $query->all();
        
        foreach($employees as $employee){
            $objects[] = [
                'id' => $employee->id,
                'firstname' => $employee->firstname,
                'email' => $employee->email,
                'image' => $employee->getImage()
            ];
        }
        
        return $this->sendResponse($error, $message, $objects);
    }
}
