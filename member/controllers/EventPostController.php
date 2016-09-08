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
     * Get event post by event id
     */
    public function actionGetEventPost() {
        $collection = [];
        $eventPostIds = [];
        $eventId = \Yii::$app->request->get('eventId');
        
        //fetch event post list
        $result = EventPost::getEventPosts($eventId, \Yii::$app->request->get('currentPage'), \Yii::$app->request->get('itemPerPage'));
        foreach ($result as $item) {
            $actionDelete = false;
            //No add condition for admin here.
            if (((\Yii::$app->user->getId() == $item->created_employee_id) || (\Yii::$app->user->identity->is_admin)) && ($item->is_log_history == false)) {
                $actionDelete = true;
            }
            
            $collection[] = [
                'id'                 => $item->id,
                'time'               => date('H:i d-m-Y ', $item->datetime_created),
                'content'            => $item->content,
                'employee_name'      => empty($item->employee) ? '' : $item->employee->getFullName(),
                'profile_image_path' => empty($item->employee) ? '' : $item->employee->getImage(),
                'actionDelete'       => $actionDelete,
            ];
            $eventPostIds[$item['id']] = $item->id;
        }

        $files = File::getFiles(array_keys($eventPostIds), EventPost::tableName());
        $fileData = [];
        foreach ($files as $val) {
            $fileData[$val->owner_id][] = [
                'name' => $val->name,
                'path' => \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $val->path
            ];
        }

        $objects['collection'] = $collection;
        $objects['files'] = $fileData;
        $objects['totalItems'] = 0;
        
        if (!empty($collection)) {
            $objects['totalItems'] = EventPost::find()->where(['event_id' => $eventId])->count();
        }
        return $this->sendResponse(false, "", $objects);
    }

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
            if (empty($dataPost['employeeList'])) return true;
            
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
            $files = File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $eventPost->id, EventPost::tableName());
            $fileList = [];
            foreach ((array)$files AS $key => $val) {
                $fileList[] = [
                        'name' => $val['name'],
                        'path' => \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $val['path']
                ];
            }
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
            
            $themeEmail = \common\models\EmailTemplate::getThemeCreateEventPost();
            $themeSms   = \common\models\SmsTemplate::getThemeCreateEventPost();
            //send email and sms
            if (!empty($arrayEmployees) && ($eventInfo->sms)) {
                $dataSend = [
                        '{creator name}' => \Yii::$app->user->identity->firstname,
                        '{event name}'  => $eventInfo->name
                ];
                $employees = new Employee();
                foreach ($arrayEmployees as $item) {
                    $employees->sendMail($dataSend, $themeEmail);
                    $employees->sendSms($dataSend, $themeSms);
                }
            }
            
            $collection= [
                    'id'                 => $eventPost->id,
                    'time'               => date('H:i d-m-Y ', $eventPost->datetime_created),
                    'content'            => $dataPost['description'],
                    'employee_name'      => \Yii::$app->user->identity->FullName,
                    'profile_image_path' => \Yii::$app->user->identity->Image,
                    'actionDelete'       => true,
            ];
            
            $transaction->commit();
            return $this->sendResponse(false, [], ['collection' => $collection, 'files' => $fileList]);
        } catch (Exception $e) {
            $transaction->rollBack();
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }
    
   /**
     * Action delete project post
     */
    public function actionRemoveEventPost() {
        $this->_message = \Yii::t('member', 'remove Event post success');
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (!EventPost::deleteAll(['id' => \Yii::$app->request->get('calendarId')])) {
                 throw new \Exception('remove event post error');
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_error = true;
            $this->_message = \Yii::t('member', 'remove event post error');
            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }
        return $this->sendResponse($this->_error, $this->_message, []);
    }
    /**
     * Action update project post
     */
    public function actionUpdateEventPost() {
    	$request = \Yii::$app->request->post();
        if (!(isset($request['id']) && $request['id'])) {
            throw new \Exception('Request fail');
        }
        
        $this->_message = "Updata Event Post Success";
        $transaction = \Yii::$app->db->beginTransaction();
        try {
        	if (!$eventPost = EventPost::findOne($request['id'])) {
        		throw new \Exception('Get event post info fail');
        	}
        	$eventPost->content       = $request['content'];
        	$eventPost->content_parse = $request['content'];
        	if (!$eventPost->update()) {
        		throw new \Exception('Save record to table event post fail');
        	}
        	$transaction->commit();
        } catch (\Exception $e) {
            $this->_message = "Error";
            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }
        
        return $this->sendResponse($this->_error, $this->_message, ['content' => $request['content']]);
    }
}
