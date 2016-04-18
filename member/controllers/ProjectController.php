<?php

namespace member\controllers;

use Yii;
use common\models\Project;
use common\models\Status;
use common\models\Priority;
use common\models\ProjectParticipant;
use common\models\Activity;
use common\models\EmployeeActivity;
use common\models\Notification;
use common\models\Employee;
use common\models\File;

class ProjectController extends ApiController {

    /**
     * get list project
     * @return type
     */
    public function actionIndex() {
        $error = false;
        $message = "";
        $collection = [];
        $itemPerPage = \Yii::$app->request->post('itemPerPage', 10);
        $currentPage = \Yii::$app->request->post('currentPage', 1);
        //fetch data
        
        $params = [':empolyee_id' => \Yii::$app->user->getId()];
        $result = Project::getProject($params, $currentPage, $itemPerPage);
        $totalItems = $this->getPagination($result['sql'], $currentPage, $itemPerPage, $params);
        
        
        foreach ($result['data'] as $item) {
            $collection[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'status_id' => $item['status_id'],
                'status' => $item['status_name'],
                'completed_percent' => $item['completed_percent'],
                'description' => strlen($item['description']) > 250 ? (substr($item['description'], 0, 70) . "...") : $item['description'],
                'theory' => $item['estimate_hour'] > 0 ? ((int)(($item['worked_hour'] / $item['estimate_hour'] ) * 100)) : 0 ,
            ];
        }
        $objects['collection'] = $collection;
        $objects['totalItems'] = (int) $totalItems;
        return $this->sendResponse($error, $message, $objects);
    }

    /**
     * add project
     */
    public function actionAdd() {
        $error = false;
        $message = "";
        $objects = [];
        $dataPost = [];
        
        $project_json = \Yii::$app->request->post('project', '');
        if (strlen($project_json)) {
            $dataPost = json_decode($project_json, true);
        }
        $transaction = \Yii::$app->db->beginTransaction();
        //create object and validate data
        try {
            $ob = new Project();
            $ob->attributes = $dataPost;
            $ob->description_parse = $ob->description;
            $ob->start_datetime = $ob->start_datetime ? strtotime($ob->start_datetime) : null;
            $ob->duedatetime = $ob->duedatetime ? strtotime($ob->duedatetime) : null;
            if (isset($dataPost['manager']['id'])) {
                $ob->manager_project_id = $dataPost['manager']['id'];
            }
            if (!$ob->save()) {
                $message = $this->parserMessage($ob->getErrors());
                $error = true;
            } else {
                //add department
                if (isset($dataPost['departments']) && count($dataPost['departments'])) {
                    foreach ($dataPost['departments'] as $value) {
                        $proPa = new ProjectParticipant();
                        $proPa->project_id = $ob->id;
                        $proPa->owner_id = $value;
                        $proPa->owner_table = ProjectParticipant::TABLE_DEPARTMENT;
                        if(!$proPa->save()){
                            throw  new \Exception('Save record to table ProjectParticipant fail');
                        }
                    }
                }
                //add member
                if (isset($dataPost['members']) && count($dataPost['members'])) {
                    foreach ($dataPost['members'] as $item) {
                        $proPa = new ProjectParticipant();
                        $proPa->project_id = $ob->id;
                        $proPa->owner_id = $item['id'];
                        $proPa->owner_table = ProjectParticipant::TABLE_EMPLOYEE;
                        if(!$proPa->save()){
                            throw new \Exception('Save record to table ProjectParticipant fail');
                        }
                    }
                }
                //move file
                File::addFiles($_FILES,\Yii::$app->params['PathUpload'],$ob->id,File::TABLE_PROJECT);

                //activity
                $activity = new Activity();
                $activity->owner_id = $ob->id;
                $activity->owner_table = Activity::TABLE_PROJECT;
                $activity->parent_employee_id = 0;
                $activity->employee_id = \Yii::$app->user->getId();
                $activity->type = "create_project";
                $activity->content = \Yii::$app->user->getIdentity()->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name;
                
                if(!$activity->save()){
                    throw  new \Exception('Save record to table Activity fail');
                }

                //Employee activity
                $employeeActivity = EmployeeActivity::find()->andCompanyId()->andWhere(['employee_id' => \Yii::$app->user->getId()])->one();
                if (!$employeeActivity) {
                    $employeeActivity = new EmployeeActivity();
                    $employeeActivity->employee_id = \Yii::$app->user->getId();
                    $employeeActivity->activity_project = $employeeActivity->activity_total = 0;
                }
                
                $employeeActivity->activity_project += 1;
                $employeeActivity->activity_total += 1;
                if(!$employeeActivity->save()){
                    throw  new \Exception('Save record to table EmployeeActivity fail');
                }
                //notifycation
                $arrayEmployees = [];
                $is_query = false;
                $query = Employee::find()->andCompanyId();
                if (isset($dataPost['departments']) && count($dataPost['departments'])) {
                    $is_query = true;
                    $query->orWhere(['department_id' => $dataPost['departments']]);
                }
                if (isset($dataPost['members']) && count($dataPost['members'])) {
                    $is_query = true;
                    $idEmployees = [];
                    foreach ($dataPost['members'] as $item) {
                        $idEmployees[] = $item['id'];
                    }
                    $query->orWhere(['id' => $idEmployees]);
                }
                if ($is_query) {
                    $content = \Yii::$app->user->getIdentity()->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name;
                    $arrayEmployees = $query->all();
                    $dataSend = [
                        '{creator name}' => \Yii::$app->user->getIdentity()->firstname,
                        '{project name}' => $ob->name
                    ];
                    foreach ($arrayEmployees as $item) {
                        $no = new Notification();
                        $no->owner_id = $ob->id;
                        $no->owner_table = Notification::TABLE_PROJECT;
                        $no->employee_id = $item->id;
                        $no->owner_employee_id = \Yii::$app->user->getId();
                        $no->type = "create_project";
                        $no->content = $content;
                        if(!$no->save()){
                            throw  new \Exception('Save record to table Notification fail');
                        }
                        //send email 
                        $themeEmail = \common\models\EmailTemplate::getThemeCreateProject();
                        $item->sendMail($dataSend, $themeEmail);

                        //send sms
                        if ($ob->sms) {
                            $themeSms = "";//\common\models\SmsTemplate::getThemeCreateProject();
                            $item->sendSms($dataSend, $themeEmail);
                            $sms = new \common\models\Sms();
                            $sms->owner_id = $ob->id;
                            $sms->employee_id = $item->id;
                            $sms->owner_table = \common\models\Sms::TABLE_PROJECT;
                            $sms->content = $content;
                            $sms->is_success = 1;
                            $sms->fee = 0;
                            if(!$sms->save()){
                                throw new \Exception('Save record to table Sms fail');
                            }
                        }
                    }
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            $error = true;
            $message = \Yii::t('member', 'error_system');
            return $this->sendResponse($error, $message, $objects);
        }
        
        return $this->sendResponse($error, $message, $objects);
    }

    /*
     * 
     */

    public function actionStatus() {
        $error = false;
        $message = "";
        $objects = [];

        $array = Status::find()->andCompanyId()->andWhere(['column_name' => 'project'])->all();
        foreach ($array as $item) {
            $objects[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        return $this->sendResponse($error, $message, $objects);
    }

    /*
     * 
     */

    public function actionPriority() {
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
