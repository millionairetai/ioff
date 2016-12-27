<?php

namespace member\controllers;

use common\models\File;
use common\models\ProjectPost;
use common\models\Project;
use common\models\Task;
use common\models\Event;
use common\models\EventPost;
use common\models\Employee;

class FileController extends ApiController {
    /*
     * Function remove file screen view project when click button delete
     */
    public function actionRemoveFile() {
        $this->_message = \Yii::t('member', 'remove file success');
        $transaction = \Yii::$app->db->beginTransaction();
        //create object and validate data
        try {
            $object = [];
            if ($result = (new File())->removeFile(\Yii::$app->request->get('fileId'))) {
                $object = [
                    'onwer_id' => $result->owner_id,
                    'owner_object' => $result->owner_object,
                    'name' => $result->name,
                    'encoded_name' => $result->encoded_name,
                    'path' => $result->path,
                    'file_type' => $result->file_type,
                    'file_size' => $result->file_size,
                ];
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $this->_error = true;
            $this->_message = \Yii::t('member', 'remove file error');
            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }

        return $this->sendResponse($this->_error, $this->_message, $object);
    }

    /*
     * Action download file.
     */
    public function actionDownloadFile1() {
        $fileId = \Yii::$app->request->get('fileId', 0);

        if ($fileId) {

            $file = File::find()->select(['id', 'name', 'path', 'datetime_created', 'owner_object', 'owner_id'])->where(['id' => $fileId])->one();
            $path = \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $file->path;
            $name = $file->name;
            if (!file_exists($path)) {
                $objects['collection']['error'] = true;
                return $this->sendResponse(false, \Yii::t('file', "File does not exist"), $objects['collection']);
            }

            if ($file) {
                //check object
                switch ($file->owner_object) {
                    case File::TABLE_EVENT || File::TABLE_EVENT_POST:
                        $eventId = '';
                        if ($file->owner_object == File::TABLE_EVENT_POST) {
                            $eventPost = EventPost::find()->select('event_id')->where(['id' => $file->owner_id])->one();
                            $eventId = $eventPost ? $eventPost->event_id : '';
                        } else {
                            $eventId = $file->owner_id;
                        }

                        //check dowloading posibility
                        if ($eventId && $event = Event::getInfoEvent($eventId)) {
                            //check authentication to view event
                            if (($event['event']['is_public'] == true) || Employee::isAdmin() || ($event['event']['creator_event_id'] == Yii::$app->user->identity->id)) {
                                return \Yii::$app->response->sendFile($path, $name);
                            } else {
                                if (EventConfirmation::isInvited($eventId)) {
                                    return \Yii::$app->response->sendFile($path, $name);
                                } else {
                                    $objects['collection']['error'] = true;
                                    return $this->sendResponse(false, \Yii::t('member', "you do not have authoirity for this action"), $objects['collection']);
                                }
                            }
                        }
                        //end check                            
                        break;

                    case File::TABLE_PROJECT || File::TABLE_PROJECT_POST:
                        break;

                    case File::TABLE_TASK || File::TABLE_TASK_POST:
                        break;

                    default:
                } //end switch  
            }
        }
    }

    /*
     * Action download file.
     */
    public function actionDownloadFile() {
        $fileId = \Yii::$app->request->get('fileId', 0);
        if ($fileId) {
            $file = File::getById($fileId, ['id', 'name', 'path', 'datetime_created', 'owner_object', 'owner_id']);
            if ($file) {
                $path = \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $file->path;
                if (!file_exists($path)) {
                    $objects['collection']['error'] = true;
                    return $this->sendResponse(false, \Yii::t('file', "File does not exist"), $objects['collection']);
                }
                return \Yii::$app->response->sendFile($path, $file->name);
                
            }
        }
    }

}
