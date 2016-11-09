<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Employee;
use common\models\Project;

class EmployeeController extends ApiController {

    // Get all calendar id from array
    public function actionSearch() {
        $objects = [];
        $keyword = Yii::$app->request->post('keyword');
        $departments = Yii::$app->request->post('departments', []);
        $members = Yii::$app->request->post('members', []);
        $manager = Yii::$app->request->post('manager', []);

        $query = Employee::find()
                    ->select(['id', 'email', 'firstname', 'lastname', 'profile_image_path'])
                    ->andCompanyId()->andWhere(['like', 'firstname', $keyword]);

        //check department
        if (!empty($departments)) {
            $query->andWhere(['not in', 'department_id', $departments]);
        }

        //check manager
        if (isset($manager['id'])) {
            $query->andWhere(['!=', 'id', $manager['id']]);
        }

        //check member
        if (!empty($members)) {
            $ids = [];
            foreach ($members as $mb) {
                $ids[] = $mb['id'];
            }
            $query->andWhere(['not in', 'id', $ids]);
        }

        if ($employees = $query->all()) {
            foreach ($employees as $employee) {
                $objects[] = [
                    'id' => $employee->id,
                    'firstname' => $employee->getFullName(),
                    'email' => $employee->email,
                    'image' => $employee->getImage()
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

    public function actionSearchByProjectIdAndKeyword() {
        $projectId = Yii::$app->request->post('project_id');
        $keyword = Yii::$app->request->post('keyword');
        
        $error = false;
        $message = "";
        $objects = [];
        $collection = [];
        
        if(($project = Project::findOne($projectId)) !== null){            
            $employees = $project->getEmployees();
            
            foreach ($employees as $employee){
                if($keyword == '' || strpos($employee->fullname,$keyword) === 0){
                    $collection[] = [
                        'id' => $employee->id,
                        'fullname' => $employee->fullname,
                        'email' => $employee->email,
                        'image' => $employee->getImage()
                    ];
                }
            }     
        }else{
            $error = true;
            $message = "NO_PROJECT_FOUND";
        }
        
        $objects['collection'] =$collection;                       
        return $this->sendResponse($error, $message, $objects);
    }
    
    public function actionSearchByKeyword(){
        $keyword = Yii::$app->request->post('keyword');
        $employees = Employee::find()->andCompanyId()->all();
        
        $error = false;
        $message = "";
        $objects = [];
        $collection = [];
        
        foreach ($employees as $employee){
            if($keyword == '' || strpos($employee->firstname,$keyword) === 0){
                $collection[] = [
                    'id' => $employee->id,
                    'firstname' => $employee->firstname,
                    'email' => $employee->email,
                    'image' => $employee->getImage()
                ];
            }
        }
                        
        $objects['collection'] =$collection;
                                
        return $this->sendResponse($error, $message, $objects);
    }    

}
