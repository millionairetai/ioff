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
use common\models\TaskPost;
use common\models\Task;

class TaskPostController extends ApiController {

    /**
     * Get task post by task id
     */
    public function actionGetTaskPost() {
        $collection = [];
        $taskPostIds = [];
        $taskId = \Yii::$app->request->get('taskId');

        //fetch task post list
        $result = TaskPost::getTaskPosts($taskId, \Yii::$app->request->get('offset'), \Yii::$app->request->get('itemPerPage'));
        foreach ($result as $item) {
            $actionDelete = false;
            //No add condition for admin here.
            if (((\Yii::$app->user->getId() == $item->created_employee_id) || (\Yii::$app->user->identity->is_admin)) && ($item->is_log_history == false)) {
                $actionDelete = true;
            }

            $collection[] = [
                'id' => $item->id,
                'time' => date('H:i d-m-Y ', $item->datetime_created),
                'content' => $item->content,
                'employee_name' => empty($item->employee) ? '' : $item->employee->getFullName(),
                'profile_image_path' => empty($item->employee) ? '' : $item->employee->getImage(),
                'actionDelete' => $actionDelete,
            ];
            $taskPostIds[$item['id']] = $item->id;
        }

        $files = File::getFiles(array_keys($taskPostIds), TaskPost::tableName());
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
            $objects['totalItems'] = TaskPost::find()->where(['task_id' => $taskId])->count();
        }
        return $this->sendResponse(false, "", $objects);
    }

    /**
     * Get lasted task post by task id
     */
    public function actionGetLastTaskPost() {
        $collection = [];
        //fetch task post list
        $taskPost = TaskPost::getLastTaskPost();
        $actionDelete = false;
        //No add condition for admin here.
        if (((\Yii::$app->user->getId() == $taskPost->created_employee_id) || (\Yii::$app->user->identity->is_admin)) && ($taskPost->is_log_history == false)) {
            $actionDelete = true;
        }

        $collection[] = [
            'id' => $taskPost->id,
            'time' => date('H:i d-m-Y ', $taskPost->datetime_created),
            'content' => $taskPost->content,
            'employee_name' => empty($taskPost->employee) ? '' : $taskPost->employee->getFullName(),
            'profile_image_path' => empty($taskPost->employee) ? '' : $taskPost->employee->getImage(),
            'actionDelete' => $actionDelete,
        ];

        $files = File::getFiles($taskPost->id, TaskPost::tableName());
        
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
            $objects['totalItems'] = TaskPost::find()->where(['task_id' => \Yii::$app->request->get('taskId')])->count();
        }
        return $this->sendResponse(false, "", $objects);
    }

    /*
     * Function remove file screen view project
     */
    public function actionAddTaskPost() {
        try {
            $transaction = \Yii::$app->db->beginTransaction();
            $dataPost = [];
            $taskJson = \Yii::$app->request->post('task', '');
            if (strlen($taskJson)) {
                $dataPost = json_decode($taskJson, true);
            }

            $taskInfo = [];
            if (isset($dataPost['taskId'])) {
                if (!$taskInfo = Task::getById($dataPost['taskId'])) {
                    throw new \Exception('Get task info fail');
                }
            }

            //insert task_post table:
            $taskPost = new TaskPost();
            $taskPost->task_id = $dataPost['taskId'];
            $taskPost->company_id = $this->_companyId;
            $taskPost->employee_id = \Yii::$app->user->getId();
            $taskPost->parent_employee_id = 0;
            $taskPost->parent_id = 0;
            $taskPost->content = $dataPost['description'];
            $taskPost->content_parse = strip_tags($dataPost['description']);
            $taskPost->is_log_history = 0;
            if (!$taskPost->save()) {
                throw new \Exception('Save record to table task post fail');
            }

            //move file
            File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $taskPost->id, TaskPost::tableName());
            $files = File::getFiles($taskPost->id, TaskPost::tableName());
            $fileData = [];
            foreach ($files as $val) {
                $fileData[] = [
                    'id' => $val->id,
                    'datetime_created' => $val->datetime_created,
                    'name' => $val->name,
                    'path' => \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $val->path
                ];
            }

            //activity
            $content = Activity::makeContent(\Yii::t('common', 'created'), $taskPost->content_parse);
            $activity = new Activity();
            $activity->owner_id = $taskPost->id;
            $activity->owner_table = TaskPost::tableName();
            $activity->parent_employee_id = 0;
            $activity->employee_id = \Yii::$app->user->getId();
            $activity->type = Activity::TYPE_CREATE_TASK_POST;
            $activity->content = $content;
            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }
           
            $arrayEmployees = !empty($dataPost['employeeList']) ? $dataPost['employeeList'] : [];
            $notifications = [];
            foreach ($arrayEmployees as $item) {
                $notifications[] = [
                    'owner_id' => $taskPost->id,
                    'owner_table' => TaskPost::tableName(),
                    'employee_id' => $item['id'],
                    'owner_employee_id' => \Yii::$app->user->getId(),
                    'type' => Activity::TYPE_CREATE_TASK_POST,
                    'content' => $content,
                ];
            }

            Notification::batchInsert($notifications);
            $themeEmail = \common\models\EmailTemplate::getThemeCreateTaskPost();
            //send email and sms
            if (!empty($arrayEmployees)) {
                $dataSend = [
                    '{creator name}' => \Yii::$app->user->identity->fullname,
                    '{task name}' => $taskInfo->name
                ];
                $employees = new Employee();
                foreach ($arrayEmployees as $item) {
                    $employees->sendMail($dataSend, $themeEmail);
                }
            }

            $collection = [
                'id' => $taskPost->id,
                'time' => date('H:i d-m-Y ', $taskPost->datetime_created),
                'content' => $dataPost['description'],
                'employee_name' => \Yii::$app->user->identity->fullName,
                'profile_image_path' => \Yii::$app->user->identity->image,
                'actionDelete' => true,
            ];

            $transaction->commit();
            return $this->sendResponse(false, [], ['collection' => $collection, 'files' => [$taskPost->id => $fileData]]);
        } catch (Exception $e) {
            $transaction->rollBack();
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }

    /**
     * Action delete project post
     */
    public function actionRemoveTaskPost() {
        $this->_message = \Yii::t('member', 'remove task post success');
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (!TaskPost::deleteAll(['id' => \Yii::$app->request->get('taskPostId')])) {
                throw new \Exception('remove task post error');
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_error = true;
            $this->_message = \Yii::t('member', 'remove task post error');
            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }
        
        return $this->sendResponse($this->_error, $this->_message, []);
    }

    /**
     * Action update project post
     */
    public function actionUpdateTaskPost() {
        $request = \Yii::$app->request->post();
        if (!(isset($request['id']) && $request['id'])) {
            throw new \Exception('Request fail');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (!$taskPost = TaskPost::findOne($request['id'])) {
                throw new \Exception('Get task post info fail');
            }
            $taskPost->content = $request['content'];
            $taskPost->content_parse = strip_tags($request['content']);
            if (!$taskPost->update()) {
                throw new \Exception('Save record to table task post fail');
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_error = true;
            $this->_message = Yii::t('member', 'Update post error');
            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }

        return $this->sendResponse($this->_error, $this->_message, ['content' => $request['content']]);
    }

}
