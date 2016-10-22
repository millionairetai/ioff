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
use common\models\Remind;
use common\models\Sms;

class TaskController extends ApiController {
    /*
     *  sms only 3 but 4
     * sms not write t db.
     * 
     */
    public function actionAdd() {
        $objects = [];
        $postData = \Yii::$app->request->post('task', '');
        if (!empty($postData)) {
            $postData = json_decode($postData, true);
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $task = new Task();
            $task->attributes = $postData;
            $task->description_parse = strip_tags($task->description);
            $task->duedatetime = $task->duedatetime ? strtotime($task->duedatetime) : null;
            
            if (!$task->save()) {
                $this->_message = $this->parserMessage($task->getErrors());
                $this->_error = true;
                throw new \Exception($this->_message);
            }

            $taskAss = [];
            $aAssignedEmployeeIds = [];
            if (!empty($postData['assigningEmployees'])) {
                foreach ($postData['assigningEmployees'] as $item) {
                    $taskAss[] = [$task->id, $item['id'],];
                    array_push($aAssignedEmployeeIds, $item['id']);
                }
            }

            $taskFollow = [];
            $aFollowedEmployeeIds = [];
            if (!empty($postData['followingEmployees'])) {
                foreach ($postData['followingEmployees'] as $item) {
                    $taskFollow[] = [$task->id, $item['id'],];
                    array_push($aFollowedEmployeeIds, $item['id']);
                }
            }

            File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $task->id, File::TABLE_TASK);
            $activity = new Activity();
            $activity->owner_id = $task->id;
            $activity->owner_table = Activity::TABLE_TASK;
            $activity->parent_employee_id = 0;
            $activity->employee_id = \Yii::$app->user->getId();
            $activity->type = Activity::TYPE_CREATE_TASK;
            $activity->content = Activity::makeContent(\Yii::t('common', 'created'), $task->name);
            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }

            $employeeActivity = EmployeeActivity::getByEmployeeId(Yii::$app->user->getId());
            if (!$employeeActivity) {
                $employeeActivity = new EmployeeActivity();
            }
            
            $employeeActivity->increase('activity_task');
            $taskGroupAllocation = [];
            if (!empty($postData['taskGroupIds'])) {
                foreach ($postData['taskGroupIds'] as $taskGroupId) {
                    $taskGroupAllocation[] = [$task->id, $taskGroupId,];
                }
            }

            $sms = [];
            $remind = [];
            $notifications = [];
            $employees = Employee::getByIds(array_merge($aAssignedEmployeeIds, $aFollowedEmployeeIds));
            $noContent = Notification::makeContent(\Yii::t('common', 'created'), $task->name);
            foreach ($employees as $employee) {
                //notification
                $notifications[] = [$task->id, Notification::TABLE_TASK, $employee->id, \Yii::$app->user->getId(), "create_task", $noContent];
                $dataSend = [
                    '{creator name}' => \Yii::$app->user->identity->fullname,
                    '{project name}' => '', //need to get
                    '{task name}' => $task->name
                ];
                //prepare data and template email, sms
                if (in_array($employee->id, $aAssignedEmployeeIds)) {
                    $themeEmail = \common\models\EmailTemplate::getThemeCreateTaskForAssigner();
                    $themeSms = \common\models\SmsTemplate::getThemeCreateTaskForAssigner();
                } else if (in_array($employee->id, $aFollowedEmployeeIds)) {
                    $themeEmail = \common\models\EmailTemplate::getThemeCreateTaskForFollower();
                    $themeSms = \common\models\SmsTemplate::getThemeCreateTaskForFollower();
                }

                //send mail
                $employee->sendMail($dataSend, $themeEmail);
                //sms
                if ($task->sms) {
                    $sms[] = [$task->id, $employee->id, \common\models\Sms::TABLE_TASK, $noContent, 1, 0];
                    $employee->sendSms($dataSend, $themeSms);
                }

                //remind
                if (!empty($postData['redmind'])) {
                    $remind[] = [$employee->id, $task->id, Remind::TABLE_TASK, $task->name, $task->duedatetime - ($postData['redmind'] * 60), $postData['redmind'], 0, 0];
                }
            }

            TaskAssignment::batchInsert($taskAss, ['task_id', 'employee_id']);
            Follower::batchInsert($taskFollow, ['task_id', 'employee_id']);
            TaskGroupAllocation::batchInsert($taskGroupAllocation, ['task_group_id', 'task_id']);
            Notification::batchInsert($notifications, ['owner_id', 'owner_table', 'employee_id', 'owner_employee_id', 'type', 'content']);
            Remind::batchInsert($remind, ['employee_id', 'owner_id', 'owner_table', 'content', 'remind_datetime', 'minute_before', 'repeated_time', 'is_snoozing']);
            Sms::batchInsert($sms, ['owner_id', 'employee_id', 'owner_table', 'content', 'is_success', 'fee']);
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_message = $e->getMessage();
            if (!$this->_error) {
                $this->_error = true;
                $this->_message = \Yii::t('member', 'error_system');
            }

            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }

        return $this->sendResponse($this->_error, $this->_message, $objects);
    }
    
    /**
     * Get parent tasks 
     */
    public function actionGetParentTasks() {
        $objects = [];
        $collection = [];
        if ($tasks = Task::getByProjectId(\Yii::$app->request->get('project_id'))) {
            foreach ($tasks as $task) {
                $collection[] = [
                    'id' => $task['id'],
                    'name' => $task['name'],
                ];
            }
        }

        $objects['collection'] = $collection;
        return $this->sendResponse(false, '', $objects);
    }

    /**
     * Get task list assigned for currrent login employee.
     */
    public function actionGetMyTasks() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $searchText = \Yii::$app->request->get('searchText');
        try {
            $collection = [];
            $totalCount = 0;
            $assignees = [];
            $followers = [];

            $tasks = Task::getMyTasks($itemPerPage, $currentPage, $searchText);
            $totalCount = $tasks['totalCount'];
            $tasks = $tasks['collection'];
            foreach ($tasks as $task) {
                $assignees = [];
                $followers = [];
                $creator = $task->creator;
                foreach ($task->assignees as $assignee) {
                    $assignees[] = ['fullname' => $assignee->fullname, 'email' => $assignee->email, 'image' => $assignee->getImage()];
                }

                foreach ($task->followers as $follower) {
                    $followers[] = ['fullname' => $follower->fullname, 'email' => $follower->email, 'image' => $follower->getImage()];
                }

                $collection[] = [
                    'id' => $task->id,
                    'name' => $task->name,
                    'description' => strlen($task->description) > 400 ? (substr($task->description, 0, 400) . "...") : $task->description,
                    'creator' => ['fullname' => $creator->fullname, 'email' => $creator->email, 'image' => $creator->getImage()],
                    'followers' => $followers,
                    'assignees' => $assignees,
                ];
            }
        } catch (\Exception $e) {
            $collection = [];
            $totalCount = 0;
        }

        $objects = [];
        $objects['collection'] = $collection;
        $objects['totalItems'] = (int) $totalCount;
        return $this->sendResponse(false, '', $objects);
    }

    /**
     * Get task list follower for currrent login employee.
     */
    public function actionGetFollowTasks() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $searchText = \Yii::$app->request->get('searchText');
        try {
            $collection = [];
            $totalCount = 0;
            $assignees = [];
            $followers = [];
            $collection = [];

            $tasks = Task::getFollowTasks($itemPerPage, $currentPage, $searchText);
            $totalCount = $tasks['totalCount'];
            $tasks = $tasks['collection'];
            foreach ($tasks as $task) {
                $assignees = [];
                $followers = [];
                $creator = $task->creator;
                foreach ($task->assignees as $assignee) {
                    $assignees[] = ['fullname' => $assignee->fullname, 'email' => $assignee->email, 'image' => $assignee->getImage()];
                }

                foreach ($task->followers as $follower) {
                    $followers[] = ['fullname' => $follower->fullname, 'email' => $follower->email, 'image' => $follower->getImage()];
                }

                $collection[] = [
                    'id' => $task->id,
                    'name' => $task->name,
                    'description' => strlen($task->description) > 400 ? (substr($task->description, 0, 400) . "...") : $task->description,
                    'creator' => ['fullname' => $creator->fullname, 'email' => $creator->email, 'image' => $creator->getImage()],
                    'followers' => $followers,
                    'assignees' => $assignees,
                ];
            }
        } catch (\Exception $e) {
            $collection = [];
            $totalCount = 0;
        }

        $objects = [];
        $objects['collection'] = $collection;
        $objects['totalItems'] = (int) $totalCount;
        return $this->sendResponse(false, '', $objects);
    }

    /**
     * Get task list follower for currrent login employee.
     */
    public function actionGetTasks() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $searchText = \Yii::$app->request->get('searchText');

        try {
            $collection = [];
            $totalCount = 0;
            $assignees = [];
            $followers = [];
            $collection = [];

            $tasks = Task::getTasks($itemPerPage, $currentPage, $searchText);
            $totalCount = $tasks['totalCount'];
            $tasks = $tasks['collection'];
            foreach ($tasks as $task) {
                $assignees = [];
                $followers = [];
                $creator = $task->creator;
                foreach ($task->assignees as $assignee) {
                    $assignees[] = ['fullname' => $assignee->fullname, 'email' => $assignee->email, 'image' => $assignee->getImage()];
                }

                foreach ($task->followers as $follower) {
                    $followers[] = ['fullname' => $follower->fullname, 'email' => $follower->email, 'image' => $follower->getImage()];
                }

                $collection[] = [
                    'id' => $task->id,
                    'name' => $task->name,
                    'description' => strlen($task->description) > 400 ? (substr($task->description, 0, 400) . "...") : $task->description,
                    'creator' => ['fullname' => $creator->fullname, 'email' => $creator->email, 'image' => $creator->getImage()],
                    'followers' => $followers,
                    'assignees' => $assignees,
                    'completed_percent' => $task->completed_percent,
                ];
            }
        } catch (\Exception $e) {
            $collection = [];
            $totalCount = 0;
        }

        $objects = [];
        $objects['collection'] = $collection;
        $objects['totalItems'] = (int) $totalCount;
        return $this->sendResponse(false, '', $objects);
    }

    /**
     * Get task list follower for currrent login employee.
     */
    public function actionGetTaskForDropdown() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $searchText = \Yii::$app->request->get('searchText');
        try {
            $result = Task::getTasks(10, 1, '');
        } catch (\Exception $e) {
            $result = [
                'collection' => [],
                'totalCount' => 0,
            ];
        }

        $objects = [];
        $objects['collection'] = $result['collection'];
        $objects['totalItems'] = (int) $result['totalCount'];
        return $this->sendResponse(false, '', $objects);
    }

    public function actionGetSearchGlobalSuggestion() {
        $currentPage = \Yii::$app->request->post('typeSearch');
        $searchText = \Yii::$app->request->post('val');

        try {
            if (trim($searchText) == '') {
                throw new \Exception('Empty search value');
            }

            $result = Task::getTasks(10, 1, '');
            foreach ($result['collection'] as $task) {
                $collection[] = $task['name'];
            }
        } catch (\Exception $e) {
            $collection[] = [];
        }


        $objects = [];
        $objects['collection'] = $collection;
        return $this->sendResponse(false, '', $objects);
    }

    public function actionGetSearchGlobalTasks() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $searchText = \Yii::$app->request->get('searchText');
        try {
            $result = Task::getTasks(10, $currentPage, $searchText);
        } catch (\Exception $e) {
            $result = [
                'collection' => [],
                'totalCount' => 0,
            ];
        }

        $objects = [];
        $objects['collection'] = $result['collection'];
        $objects['totalItems'] = (int) $result['totalCount'];
        return $this->sendResponse(false, '', $objects);
    }

}
