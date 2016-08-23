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
use common\models\EventPost;
use common\models\Event;

class EventPostController extends ApiController {

    /**
     * Get project post by project id
     */
//     public function actionGetProjectPost() {
//         $collection = [];
//         $projectPostIds = [];
//         $projectId = \Yii::$app->request->post('projectId');
//         //fetch project post list
//         $result = ProjectPost::getProjectPosts($projectId, \Yii::$app->request->post('currentPage'), \Yii::$app->request->post('itemPerPage'));
//         foreach ($result as $item) {
//             $actionDelete = false;
//             if (((\Yii::$app->user->getId() == $item->created_employee_id) || (\Yii::$app->user->identity->is_admin)) && ($item->is_log_history == false)) {
//                 $actionDelete = true;
//             }
//             $collection[] = [
//                 'id'                 => $item->id,
//                 'time'               => date('H:i d-m-Y ', $item->datetime_created),
//                 'content'            => $item->content,
//                 'employee_name'      => empty($item->employee) ? '' : $item->employee->getFullName(),
//                 'profile_image_path' => empty($item->employee) ? '' : $item->employee->getImage(),
//                 'actionDelete'       => $actionDelete,
//             ];

//             $projectPostIds[$item['id']] = $item->id;
//         }


//         $files = File::getFiles(array_keys($projectPostIds), ProjectPost::TABLE_PROJECTPOST);
//         $fileData = [];

//         foreach ($files AS $key => $val) {
//             $fileData[$val->owner_id][] = [
//                 'name' => $val->name,
//                 'path' => \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $val->path
//             ];
//         }

//         $objects['collection'] = $collection;
//         $objects['files'] = $fileData;
//         $objects['totalItems'] = 0;
//         $objects['debugs'] = \Yii::$app->request->post('currentPage') . '++++'.  \Yii::$app->request->post('itemPerPage');
        
//         if (!empty($collection)) {
//             $objects['totalItems'] = Projectpost::find()->where(['project_id' => $projectId])->count();
//         }

//         return $this->sendResponse(false, "", $objects);
//     }

    /*
     * Function remove file screen view project
     */
    public function actionAddEventPost() {
        try {
            $transaction = \Yii::$app->db->beginTransaction();
            $dataPost = [];
            $eventson = \Yii::$app->request->post('event', '');
            if (strlen($eventson)) {
                $dataPost = json_decode($eventson, true);
            }
            $eventInfo = [];
            if (isset($dataPost['calendarId'])) {
                if (!$eventInfo = Event::find()->select(['id', 'name'])->where(['id' => $dataPost['calendarId']])->one()) {
                    throw new \Exception('Get Event info fail');
                }
            }
            //insert event_post table:
            $eventPost = new EventPost();
            $eventPost->event_id            = $dataPost['calendarId'];
            $eventPost->company_id          = $this->_companyId;
            $eventPost->employee_id         = \Yii::$app->user->getId();
            $eventPost->parent_employee_id  = 0;
            $eventPost->parent_id           = 0;
            $eventPost->content             = $dataPost['description'];
            $eventPost->content_parse       = strip_tags($dataPost['description']);
            $eventPost->is_log_history      = 0;
            
            if (!$eventPost->save()) {
                throw new \Exception('Save record to table project post fail');
            }

            //move file
            $fileList = File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $eventPost->id, EventPost::tableName());
            
            //activity
            $content = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $eventInfo->name;
            $activity = new Activity();
            $activity->owner_id         = $eventPost->id;
            $activity->owner_table      = EventPost::tableName();
            $activity->parent_employee_id = 0;
            $activity->employee_id      = \Yii::$app->user->getId();
            $activity->type             = Activity::TYPE_CREATE_EVENT_POST;
            $activity->content          = $content;
            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }

            //notifycation
            $themeEmail = \common\models\EmailTemplate::getThemeProjectPost();//node fix lai get template event post
            $dataSend = [
                '{creator name}' => \Yii::$app->user->identity->firstname,
                '{project name}' => $eventInfo->name
            ];
    
            $arrayEmployees = $dataPost['employeeList'];
            $dataInsert = [];
            foreach ($arrayEmployees as $item) {
                $dataInsert['notification'][] = [
                    'owner_id'          => $eventPost->id,
                    'owner_table'       => EventPost::tableName(),
                    'employee_id'       => $item['id'],
                    'owner_employee_id' => \Yii::$app->user->getId(),
                    'type'              => Activity::TYPE_CREATE_EVENT_POST,
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
                        'owner_id'    => $eventPost->id,
                        'employee_id' => $item['id'],
                        'owner_table' => EventPost::tableName(),
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
            return $this->sendResponse(false, \Yii::t('member', 'error_system'), []);
        } catch (Exception $e) {
            $transaction->rollBack();
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }
    
//    /**
//      * Action delete project post
//      */
//     public function actionRemoveProjectPost() {
//         $this->_message = \Yii::t('member', 'remove project post success');
//         $transaction = \Yii::$app->db->beginTransaction();
//         try {
//             if (!ProjectPost::deleteAll(['id' => \Yii::$app->request->get('ProjectPostId')])) {
//                  throw new \Exception('remove project post error');
//             }
//             $transaction->commit();
//         } catch (\Exception $e) {
//             $this->_error = true;
//             $this->_message = \Yii::t('member', 'remove project post error');
//             $transaction->rollBack();
//             return $this->sendResponse($this->_error, $this->_message, []);
//         }
//         return $this->sendResponse($this->_error, $this->_message, []);
//     }
//     /**
//      * Action update project post
//      */
//     public function actionUpdateProjectPost() {
//     	$request = \Yii::$app->request->post();
//         if (!(isset($request['id']) && $request['id'])) {
//             throw new \Exception('Request fail');
//         }
//         $this->_message = "Updata Project Post Success";
//         $transaction = \Yii::$app->db->beginTransaction();
//         try {
//         	if (!$projectPost = ProjectPost::findOne($request['id'])) {
//         		throw new \Exception('Get project post info fail');
//         	}
//         	$projectPost->content       = $request['content'];
//         	$projectPost->content_parse = $request['content'];
//         	if (!$projectPost->update()) {
//         		throw new \Exception('Save record to table project post fail');
//         	}
//         	$transaction->commit();
//         } catch (\Exception $e) {
//             $this->_message = "Error";
//             $transaction->rollBack();
//             return $this->sendResponse($this->_error, $this->_message, []);
//         }
        
//         return $this->sendResponse($this->_error, $this->_message, ['content' => $request['content']]);
//     }
}
