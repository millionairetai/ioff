<?php

namespace member\controllers;

use Yii;
use common\models\Project;
use common\models\ProjectParticipant;
use common\models\Activity;
use common\models\Notification;
use common\models\Employee;
use common\models\File;
use common\models\Sms;
use common\models\ProjectPost;

class ProjectPostController extends ApiController {

    /**
     * Get project post by project id
     */
    public function actionGetProjectPost() {
        $collection = [];
        $projectPostIds = [];
        $projectId = \Yii::$app->request->post('projectId');

        //fetch project post list
        $result = ProjectPost::getProjectPosts($projectId, \Yii::$app->request->post('currentPage'), \Yii::$app->request->post('itemPerPage'));
        foreach ($result as $item) {
            $collection[] = [
                'id'                 => $item->id,
                'time'               => date('H:i d-m-Y ', $item->datetime_created),
                'content'            => $item->content,
                'employee_name'      => empty($item->employee) ? '' : $item->employee->getFullName(),
                'profile_image_path' => empty($item->employee) ? '' : $item->employee->getImage(),
            ];

            $projectPostIds[$item['id']] = $item->id;
        }


        $files = File::getFiles(array_keys($projectPostIds), ProjectPost::TABLE_PROJECTPOST);
        $fileData = [];

        foreach ($files AS $key => $val) {
            $fileData[$val->owner_id][] = [
                'name' => $val->name,
                'path' => \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $val->path
            ];
        }

        $objects['collection'] = $collection;
        $objects['files'] = $fileData;
        $objects['totalItems'] = 0;
        
        if (!empty($collection)) {
            $objects['totalItems'] = Projectpost::find()->where(['project_id' => $projectId])->count();
        }

        return $this->sendResponse(false, "", $objects);
    }

    /*
     * Function remove file screen view project
     */
    public function actionAddProjectPost() {
        try {
            $transaction = \Yii::$app->db->beginTransaction();
            $dataPost = [];
            $projectJson = \Yii::$app->request->post('project', '');
    
            if (strlen($projectJson)) {
                $dataPost = json_decode($projectJson, true);
            }
            
            $projectInfo = [];
            if (isset($dataPost['project_id'])) {
                if (!$projectInfo = Project::findOne($dataPost['project_id'])) {
                     throw new \Exception('Get project info fail');
                }
            }
            
            //insert project_post table:
            $projectPost = new ProjectPost();
            $projectPost->project_id    = $projectInfo->id;
            $projectPost->employee_id   = \Yii::$app->user->getId();
            $projectPost->parent_id     = 0;
            $projectPost->content       = $dataPost['description'];
            $projectPost->content_parse = $dataPost['description'];
            $projectPost->parent_employee_id = 0;
            
            if (!$projectPost->save()) {
                throw new \Exception('Save record to table project post fail');
            }
            
            $content = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $projectInfo->name;
            
            //activity
            $activity = new Activity();
            $activity->owner_id = $projectPost->id;
            $activity->owner_table = ProjectPost::TABLE_PROJECTPOST;
            $activity->parent_employee_id = 0;
            $activity->employee_id = \Yii::$app->user->getId();
            $activity->type = "create_project_post";
            $activity->content = $content;
    
            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }

            //move file
            File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $projectPost->id, ProjectPost::TABLE_PROJECTPOST);
    
            //notifycation
            $themeEmail = \common\models\EmailTemplate::getThemeProjectPost();
            $themeSms   = \common\models\SmsTemplate::getThemeProjectPost();
            $dataSend = [
                '{creator name}' => \Yii::$app->user->identity->firstname,
                '{project name}' => $projectInfo->name
            ];
    
            $projectParticipants = ProjectParticipant::findAll(['company_id' => $this->_companyId, 'project_id' => $projectInfo->id]);
            $participants = $employeeList = [];
            if (!empty($projectParticipants)) {
                foreach ($projectParticipants AS $projectParticipant) {
                    $participants[$projectParticipant->owner_table][] = $projectParticipant->owner_id;
                    if ($projectParticipant->owner_table == 'department') {
                        $departmentNames[$projectParticipant->department->id] = $projectParticipant->department->name;
                    }
                }
            }
            
            $employeeIds = isset($participants['employee']) ? $participants['employee'] : null;
            $departmentIds = isset($participants['department']) ? $participants['department'] : null;
            $employees = Employee::find()
                    ->select(['id', 'firstname', 'lastname', 'profile_image_path'])
                    ->andCompanyId()
                    ->andWhere(['id' => $employeeIds])
                    ->orWhere(['department_id' => $departmentIds])
                    ->all();
            
            foreach ($employees as $employee) {
                $employeeList[] = [
                        'id'        => $employee->id,
                        'firstname' => $employee->getFullName(),
                        'image'     => $employee->getImage()
                ];
            }
            
            $arrayEmployees = $employeeList;
            $dataInsert = [];
            
            foreach ($arrayEmployees as $item) {
                $dataInsert['notification'][] = [
                    'owner_id'          => $projectPost->id,
                    'owner_table'       => ProjectPost::TABLE_PROJECTPOST,
                    'employee_id'       => $item['id'],
                    'owner_employee_id' => \Yii::$app->user->getId(),
                    'type'              => 'create_project_post',
                    'content'           => $content,
                ];
                    
                //send email
                $employee = new Employee();
                $employee->id = $item['id'];
                $employee->sendMail($dataSend, $themeEmail);
                //send sms
                $project = new Project();
                if ($project->sms) {
                    $dataInsert['sms'][] = [
                        'owner_id'    => $projectPost->id,
                        'employee_id' => $item['id'],
                        'owner_table' => ProjectPost::TABLE_PROJECTPOST,
                        'content'     => $content,
                        'is_success'  => \common\components\db\ActiveRecord::VAL_TRUE,
                        'fee'         => 0,
                        'agency_gateway' => 'esms'
                    ];
                }
            }

            if (!empty($dataInsert['notification'])) {
                if (!\Yii::$app->db->createCommand()->batchInsert(Notification::tableName(), array_keys($dataInsert['notification'][0]), $dataInsert['notification'])->execute()) {
                    throw new \Exception('Save record to table Notification fail');
                }
            }

            if (!empty($dataInsert['sms'])) {
                if (!\Yii::$app->db->createCommand()->batchInsert(Sms::tableName(), array_keys($dataInsert['sms'][0]), $dataInsert['sms'])->execute()) {
                    throw new \Exception('Save record to table Sms fail');
                }
            }
            
            $transaction->commit();
            return $this->sendResponse(false, "", []);
        } catch (Exception $e) {
            $transaction->rollBack();
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }
}