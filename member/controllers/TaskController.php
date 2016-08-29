<?php

namespace member\controllers;

use Yii;
use common\models\Project;
use common\models\Activity;
use common\models\EmployeeActivity;
use common\models\Employee;
use common\models\File;
use common\models\Task;
use common\models\TaskGroup;
use common\models\TaskGroupAllocation;
use common\models\TaskAssignment;
use common\models\Follower;
use common\models\Notification;

class TaskController extends ApiController {     
    
    public function actionAdd() {
        $error = false;
        $message = "";
        $objects = [];
        $postData = [];

        $postData = \Yii::$app->request->post('task', '');
        if (!empty($postData)) {
            $postData = json_decode($postData, true);            
        }
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $task = new Task();
            $task->attributes = $postData;
            $task->description_parse = $task->description;
            $task->duedatetime = $task->duedatetime ? strtotime($task->duedatetime) : null;
            
            if ($task->save()) {
                $aAssignedEmployeeIds = [];
                if (!empty($postData['assigningEmployees'])) {
                    $taskAss = new TaskAssignment();
                    foreach ($postData['assigningEmployees'] as $item) {
                        $taskAss->task_id = $task->id;
                        $taskAss->employee_id = $item['id'];

                        if ($taskAss->save()) {
                            array_push($aAssignedEmployeeIds, $item['id']);
                        } else {
                            throw new \Exception('saving record to table task_assignment fail');
                        }
                    }
                }
                
                $aFollowedEmployeeIds = [];
                if (!empty($postData['followingEmployees'])) {
                    $taskFollow = new Follower();
                    foreach ($postData['followingEmployees'] as $item) {
                        $taskFollow->task_id = $task->id;
                        $taskFollow->employee_id = $item['id'];
                        
                        if ($taskFollow->save()) {
                            array_push($aFollowedEmployeeIds, $item['id']);
                        } else {
                            throw new \Exception('Save record to table follower fail');
                        }
                    }
                }
                
                File::addFiles($_FILES,\Yii::$app->params['PathUpload'], $task->id, File::TABLE_TASK);                
                $activity = new Activity();
                $activity->owner_id = $task->id;
                $activity->owner_table = Activity::TABLE_TASK;
                $activity->parent_employee_id = 0;
                $activity->employee_id = \Yii::$app->user->getId();
                $activity->type = "create_task";
                $activity->content = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $task->name;
                if (!$activity->save()) {
                    throw new \Exception('Save record to table Activity fail');
                }
                
                $employeeActivity = EmployeeActivity::find()->andWhere(['employee_id' => \Yii::$app->user->getId()])->andCompanyId()->one();
                if (!$employeeActivity) {
                    $employeeActivity = new EmployeeActivity();
                    $employeeActivity->employee_id = \Yii::$app->user->getId();
                    $employeeActivity->activity_task = $employeeActivity->activity_total = 0;
                }

                $employeeActivity->activity_task  += 1;
                $employeeActivity->activity_total += 1;
                if (!$employeeActivity->save()) {
                    throw new \Exception('Save record to employee_activity table fail');
                }
               
                if(!empty($postData['taskGroupIds'])) {
                    $taskGroupAllocation = new TaskGroupAllocation();
                    foreach ($postData['taskGroupIds'] as $taskGroupId) {
                        $taskGroupAllocation->task_id = $task->id;
                        $taskGroupAllocation->task_group_id = $taskGroupId;
                        
                        if (!$taskGroupAllocation->save()) {
                            throw new \Exception('Saving record to table task_group_allocation fail');
                        }
                    }
                }
                
                $employees = Employee::find()->select([Employee::tableName().'.id', Employee::tableName().'.email', 'firstname', 'lastname'])
                                ->where([Employee::tableName().'.id' => array_merge($aAssignedEmployeeIds, $aFollowedEmployeeIds)])
                                ->andCompanyId()
                                ->all();
                
                $notificationContent = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $task->name;
                foreach ($employees as $employee) {
                    //notification
                    $no = new Notification();
                    $no->owner_id = $task->id;
                    $no->owner_table = Notification::TABLE_TASK;
                    $no->employee_id = $employee->id;
                    $no->owner_employee_id = \Yii::$app->user->getId();
                    $no->type = "create_task";
                    $no->content = $notificationContent;

                    if (!$no->save()) {
                        throw new \Exception('Save to table Notification fail');
                    }

                    $dataSend = [
                        '{creator name}' => \Yii::$app->user->identity->firstname,
                        '{project name}' => '', //need to get
                        '{task name}' => $task->name
                    ];
                    //prepare data and template email, sms
                    if (in_array($employee->id, $aAssignedEmployeeIds)) {
                        $themeEmail = \common\models\EmailTemplate::getThemeCreateTaskForAssigner(); //
                        $themeSms = \common\models\SmsTemplate::getThemeCreateTaskForAssigner(); //
                    } else if (in_array($employee->id, $aFollowedEmployeeIds)) {
                        $themeEmail = \common\models\EmailTemplate::getThemeCreateTaskForFollower(); //
                        $themeSms = \common\models\SmsTemplate::getThemeCreateTaskForFollower(); //
                    }

                    //send mail
                    $employee->sendMail($dataSend, $themeEmail);

                    //sms
                    if (!empty($postData['sms'])) {
                        $sms = new \common\models\Sms();
                        $sms->owner_id = $task->id;
                        $sms->employee_id = $employee->id;
                        $sms->owner_table = \common\models\Sms::TABLE_TASK;
                        $sms->content = $notificationContent;
                        $sms->is_success = 1;
                        $sms->fee = 0;
                        if (!$sms->save()) {
                            throw new \Exception('saving record to table Sms fail');
                        }

                        //send sms
                        $employee->sendSms($dataSend, $themeSms);
                    }
                }//end foreach employees
            } else {
                $message = $this->parserMessage($task->getErrors());
                $error = true;
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            $error = true;
            $message = \Yii::t('member', 'error_system'); 
        }

        return $this->sendResponse($error, $message, $objects);
    }    
    
    public function actionGetTasksByProject() {        
        $projectId = \Yii::$app->request->get('project_id');
        $tasks = Project::findOne($projectId)->getTasks()->select([Task::tableName().'.id',Task::tableName().'.name'])->joinWith('company')->all();
        $collection = [];
        
        foreach ($tasks as $task){
            $collection[] = [
                'id'=>$task->id,
                'name'=>$task->name,
            ];
        }
        
        $objects = [];
        $objects['collection'] = $collection;
        
        return $this->sendResponse(FALSE, '', $objects);        
    }
    
    public function actionGetTaskGroup() {
        $projectId = Yii::$app->request->get('project_id');
        $objects = [];
        $collection = [];

        $taskGroups = TaskGroup::find()->select(['id','name'])->where(['project_id' => $projectId])->andCompanyId()->all();
        foreach ($taskGroups as $taskGroup) {
            $collection[] = [
                'id'   => $taskGroup->id,
                'name' => $taskGroup->name
            ];
        }

        $objects['collection'] = $collection;
        return $this->sendResponse(false, "", $objects);
    }       
    
    public function actionGetAssignedTasks() {
        $employeeId = \Yii::$app->user->getId();
        $itemPerPage = \Yii::$app->request->get('count');
        $currentPage = \Yii::$app->request->get('page');
        $search_text = \Yii::$app->request->get('search_text');
        $employee = new Employee(['id'=>$employeeId]);
        
        $query = $employee->getAssignedTasks();
        
        if($search_text){
            $query->andFilterWhere(['like', 'name', $search_text]);
        }
                        
        $totalCount = $query->count();
        
        $tasks = $query
                ->with(['assignees'=>function ($query) {
//                    $query->select([Employee::tableName().'.firstname',Employee::tableName().'.email',Employee::tableName().'.profile_image_path']);
                }])
                
                ->with(['creator'=>function ($query) {
//                    $query->select([Employee::tableName().'.firstname',Employee::tableName().'.email',Employee::tableName().'.profile_image_path']);
                }])
                
                ->with(['followers'=>function ($query) {
//                    $query->select([Employee::tableName().'.firstname',Employee::tableName().'.email',Employee::tableName().'.profile_image_path']);
                }])
                
                ->limit($itemPerPage)->offset(($currentPage-1)*$itemPerPage)->all();
//        echo $query->createCommand()->sql;die();
        $collection = [];
        
        foreach ($tasks as $task){            
            $creator = $task->creator;            
            $assignees = [];
            $followers = [];
//            var_dump($task->id);
//            if(empty($task->creator)) {
//                var_dump($task->id);
//                var_dump($task->creator);die;
//            }
            foreach($task->assignees as $assignee){
                $assignees[] = ['firstname'=>$assignee->firstname,'email'=>$assignee->email,'image'=>$assignee->getImage()];
            }
                                    
            foreach($task->followers as $follower){
                $followers[] = ['firstname'=>$follower->firstname,'email'=>$follower->email,'image'=>$follower->getImage()];
            }
            
            $collection[] = [
                'id' => $task->id,
                'name' => $task->name,
                'description' => strlen($task->description) > 70 ? (substr($task->description, 0, 70) . "...") : $task->description,
                'creator' => ['firstname'=>$creator->firstname,'email'=>$creator->email,'image'=>$creator->getImage()],
                'followers' => $followers,
                '$assignees' => $assignees,
            ];    
//            var_dump($task->followers);die;
        }
        
        
//                exit();
        
        $objects = [];
        $objects['collection'] = $collection;                
        //total count
        $objects['totalCount'] = (int) $totalCount;
                                               
        return $this->sendResponse(FALSE, '', $objects);        
    }   
}
