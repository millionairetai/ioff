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
use common\models\TaskPost;

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
            $task->employee_id = Yii::$app->user->getId();

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
            TaskGroupAllocation::batchInsert($taskGroupAllocation, ['task_id', 'task_group_id',]);
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

    public function actionGetTasksByProject() {
        $collection = [];
        $tasks = Task::find()
                ->select(['id', 'name'])
                ->where(['project_id' => \Yii::$app->request->get('project_id')])
                ->andCompanyId()
                ->all();

        foreach ($tasks as $task) {
            $collection[] = [
                'id' => $task->id,
                'name' => $task->name,
            ];
        }

        $objects = [];
        $objects['collection'] = $collection;
        return $this->sendResponse(false, '', $objects);
    }

    public function actionGetTaskGroup() {
        $projectId = Yii::$app->request->get('project_id');
        $objects = [];
        $collection = [];

        $taskGroups = TaskGroup::find()->select(['id', 'name'])->where(['project_id' => $projectId])->andCompanyId()->all();
        foreach ($taskGroups as $taskGroup) {
            $collection[] = [
                'id' => $taskGroup->id,
                'name' => $taskGroup->name
            ];
        }

        $objects['collection'] = $collection;
        return $this->sendResponse(false, "", $objects);
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
     * Get my task for dropdown
     */
    public function actionGetTaskForDropdown() {
        try {
            return $this->sendResponse(false, '', Task::getMyTaskForDropdown(\Yii::$app->request->post('currentPage'), 10));
        } catch (\Exception $e) {
            $result = [
                'collection' => [],
                'totalCount' => 0,
            ];
        }

        return $this->sendResponse(false, '', $result);
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

    /**
     * Function to view task
     * @throws \Exception
     */
    public function actionView() {
        try {
            $dataTask['no_data'] = true;
            if ($taskId = \Yii::$app->request->get('taskId')) {
                if ($dataTask = Task::getInfoTask($taskId)) {
                    //check authentication to view task
                    if (($dataTask['assignView'] == true) || ($dataTask['task']['is_public'] == true) ||
                            Employee::isAdmin() || ($dataTask['task']['creator_event_id'] == Yii::$app->user->identity->id)) {
                        $dataTask['no_data'] = false;
                        return $this->sendResponse(false, "", $dataTask);
                    } else {
                        return $this->sendResponse(false, "", ['no_authority' => true]);
                    }
                } else {
                    return $this->sendResponse(true, \Yii::t('member', 'Can not get data'), ['no_data' => true]);
                }
            }
        } catch (\Exception $e) {
            return $this->sendResponse(true, \Yii::t('member', 'Can not get data'), []);
        }

        return $this->sendResponse(true, \Yii::t('member', 'Can not get data'), $dataTask);
    }

    /**
     * Edit vent
     * @throws \Exception
     */
    public function actionEdit() {
        $objects = [];
        $dataPost = [];
        $taskJson = \Yii::$app->request->post('task', '');
        if (strlen($taskJson)) {
            $dataPost = json_decode($taskJson, true);
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //Check if get task is null value.
            if (!$task = Task::getById($dataPost['id'])) {
                throw new \Exception('Get task info fail');
            }

            $task->attributes = $dataPost;
            $task->description_parse = $task->description;
            $task->duedatetime = $dataPost['duedatetime'] ? strtotime($dataPost['duedatetime']) : null;
            if (!$task->save()) {
                $this->_message = $this->parserMessage($task->getErrors());
                $this->_error = true;
                throw new \Exception($this->_message);
            }

            //update table task_assignment
            $assignmenMerge = $this->_mergeDataAssignmen($dataPost);
            $this->_updataTaskAssignmen($dataPost, $assignmenMerge);

            //update table task_assignment
            $followerMerge = $this->_mergeDataFollower($dataPost);
            $this->_updataTaskFollower($dataPost, $followerMerge);

            //update table Remind
            $mergeEmployee = $this->_mergeDataEmployees($dataPost);
            $this->_updataRemind($dataPost, $mergeEmployee, $task);

            //move file
            $dataPost['fileList'] = File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $task->id, Task::tableName());

            //update table activity
            $activity = new Activity();
            $activity->owner_id = $task->id;
            $activity->owner_table = Task::tableName();
            $activity->parent_employee_id = 0;
            $activity->employee_id = \Yii::$app->user->getId();
            $activity->type = Activity::TYPE_EDIT_TASK;
            $activity->content = Activity::makeContent(\Yii::t('common', 'edited'), $task->name);
            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }

            //update table Notification
            if (!empty($mergeEmployee['employees'])) {
                //save sms
                $dataInsertSms = $dataInsertNotification = [];
                foreach ($mergeEmployee['employees'] as $key => $val) {
                    $dataInsertNotification[] = [
                        'owner_id' => $task->id,
                        'owner_table' => Task::tableName(),
                        'employee_id' => $val,
                        'type' => Activity::TYPE_EDIT_TASK,
                        'content' => Notification::makeContent(\Yii::t('common', 'edited'), $task->name),
                        'owner_employee_id' => 0
                    ];

                    if ($task->sms) {
                        $dataInsertSms[] = [
                            'owner_id' => $task->id,
                            'employee_id' => $val,
                            'owner_table' => Task::tableName(),
                            'content' => Sms::makeContent(\Yii::t('common', 'edited'), $task->name),
                            'is_success' => true,
                            'fee' => 0,
                            'agency_gateway' => 'esms'
                        ];
                    }
                }

                Notification::batchInsert($dataInsertNotification);
                Sms::batchInsert($dataInsertSms);
            }

            //update table task group
            $taskGroupMerge = $this->_mergeDataTaskGroup($dataPost);
            $this->_updataTaskGroup($dataPost, $taskGroupMerge);

            //Write log history for editing this project.
            $dataPost['employeeMegre'] = $mergeEmployee;
            $postNew = false;
            if (($taskHistory = $this->_makeTaskHistory($dataPost, $task)) && !empty($taskHistory)) {
                //insert project_post table:
                $taskPost = new TaskPost();
                $taskPost->task_id = $task->id;
                $taskPost->company_id = $this->_companyId;
                $taskPost->employee_id = \Yii::$app->user->getId();
                $taskPost->parent_employee_id = 0;
                $taskPost->parent_id = 0;
                $taskPost->content = $taskHistory;
                $taskPost->content_parse = $taskHistory;
                $taskPost->is_log_history = true;
                $postNew = true;
                if (!$taskPost->save()) {
                    throw new \Exception('Save record to table task_post fail');
                }
            }

            $themeEmail = \common\models\EmailTemplate::getThemeEditTask();
            $themeSms = \common\models\SmsTemplate::getThemeEditTask();
            //send email and sms
            if (!empty($mergeEmployee['employees'])) {
                $dataSend = [
                    '{creator name}' => \Yii::$app->user->identity->fullname,
                    '{task name}' => $task->name
                ];

                $employees = new Employee();
                foreach ($mergeEmployee['employees'] as $item) {
                    $employees->sendMail($dataSend, $themeEmail);
                    if ($task->sms) {
                        $employees->sendSms($dataSend, $themeSms);
                    }
                }
            }

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

        return $this->sendResponse($this->_error, $this->_message, ['postnew' => $postNew]);
    }

    /**
     * Function update remind
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataRemind($dataPost = [], $dataMegre = [], $object = null) {
        if (empty($dataPost['id']))
            return false;
        if (empty($dataMegre))
            return true;
        if (empty($object))
            return true;

        $taskId = $dataPost['id'];

        //check update remind time
        $dataUpdate = [];
        if ($dataPost['redmind'] != $dataPost['data_old']['task']['remind']) {
            if (!\Yii::$app->db->createCommand()->update(Remind::tableName(), [
                        'remind_datetime' => $object->start_datetime - ($dataPost['redmind'] * 60),
                        'minute_before' => isset($dataPost['redmind']) ? $dataPost['redmind'] : 0], [
                        'owner_id' => $taskId, 'company_id' => $this->_companyId,
                        'owner_table' => Task::tableName()])->execute()
            ) {
                throw new \Exception('Save record to table remind fail');
            }
        }

        //Delete employee
        if (!empty($dataMegre['employeeOld'])) {
            Remind::deleteAll([
                'company_id' => $this->_companyId,
                'employee_id' => array_values($dataMegre['employeeOld']),
                'owner_id' => $taskId,
                'owner_table' => Task::tableName(),
            ]);
        }

        //Add new employee
        $dataInsertRemind = [];
        if (!empty($dataMegre['employeeNew'])) {
            foreach ($dataMegre['employeeNew'] as $val) {
                $dataInsertRemind[] = [
                    'employee_id' => $val,
                    'owner_id' => $taskId,
                    'owner_table' => Task::tableName(),
                    'content' => $dataPost['name'],
                    'remind_datetime' => $object->start_datetime - ($dataPost['redmind'] * 60),
                    'minute_before' => isset($dataPost['redmind']) ? $dataPost['redmind'] : 0,
                    'repeated_time' => 0,
                    'is_snoozing' => 0,
                ];
            }
        }

        Remind::batchInsert($dataInsertRemind);
        return true;
    }

    /**
     * Function update Invitation
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataTaskAssignmen($data, $dataMegre) {
        if (empty($data['id']) || empty($data['project_id']))
            return false;

        $taskId = $data['id'];
        if ($data['project_id'] != $data['data_old']['task']['project_id']) {
            TaskAssignment::delete([
                'task_id' => $taskId,
                'company_id' => $this->_companyId,
            ]);
        } else {
            //delete department table Invitation
            if (!empty($dataMegre['employeeOld'])) {
                TaskAssignment::deleteAll([
                    'task_id' => $data['id'],
                    'employee_id' => $dataMegre['employeeOld'],
                    'company_id' => $this->_companyId,
                ]);
            }
        }
        //Add new department
        if (!empty($dataMegre['employeeNew'])) {
            $dataInsertAssignment = [];
            foreach ($dataMegre['employeeNew'] as $id) {
                $dataInsertAssignment[] = [
                    'task_id' => $taskId,
                    'employee_id' => $id,
                ];
            }
            TaskAssignment::batchInsert($dataInsertAssignment);
        }
        return true;
    }

    /**
     * Function update Invitation
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataTaskFollower($data, $dataMegre) {
        if (empty($data['id']) || empty($data['project_id']))
            return false;

        $taskId = $data['id'];
        if ($data['project_id'] != $data['data_old']['task']['project_id']) {
            Follower::delete([
                'task_id' => $taskId,
                'company_id' => $this->_companyId,
            ]);
        } else {
            //delete department table Invitation
            if (!empty($dataMegre['employeeOld'])) {
                Follower::deleteAll([
                    'task_id' => $data['id'],
                    'employee_id' => $dataMegre['employeeOld'],
                    'company_id' => $this->_companyId,
                ]);
            }
        }
        //Add new department
        if (!empty($dataMegre['employeeNew'])) {
            $dataInsertAssignment = [];
            foreach ($dataMegre['employeeNew'] as $id) {
                $dataInsertAssignment[] = [
                    'task_id' => $taskId,
                    'employee_id' => $id,
                ];
            }
            Follower::batchInsert($dataInsertAssignment);
        }
        return true;
    }

    /**
     * Function update Invitation
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataTaskGroup($data, $dataMegre) {
        if (empty($data['id']) || empty($data['project_id']))
            return false;

        $taskId = $data['id'];
        if ($data['project_id'] != $data['data_old']['task']['project_id']) {
            TaskGroupAllocation::deleteAll([
                'task_id' => $taskId,
                'task_group_id' => $data['taskGroupIds'],
            ]);
        } else {
            //delete taskGroup table taskGroup
            if (!empty($dataMegre['taskGroupOld'])) {
                TaskGroupAllocation::deleteAll([
                    'task_id' => $taskId,
                    'task_group_id' => $dataMegre['taskGroupOld'],
                ]);
            }
        }
        //Add new department
        if (!empty($dataMegre['taskGroupNew'])) {
            $dataTaskGroupNew = [];
            foreach ($dataMegre['taskGroupNew'] as $id) {
                $dataTaskGroupAllocationNew[] = [
                    'task_group_id' => $id,
                    'task_id' => $taskId,
                ];
            }
            TaskGroupAllocation::batchInsert($dataTaskGroupAllocationNew);
        }
        return true;
    }

    /**
     * Function update or add info in table task_assignment of screen edit task
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _mergeDataAssignmen($dataPost = []) {
        if (empty($dataPost))
            return false;

        $employeeOld = !empty($dataPost['data_old']['assignees']) ? $dataPost['data_old']['assignees'] : null;
        $employeeNew = !empty($dataPost['assigningEmployees']) ? $dataPost['assigningEmployees'] : null;
        return $this->_mergeData($employeeOld, $employeeNew);
    }

    /**
     * Function update or add info in table project_participant of screen edit project
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _mergeDataFollower($dataPost = []) {
        if (empty($dataPost))
            return false;

        $employeeOld = !empty($dataPost['data_old']['followers']) ? $dataPost['data_old']['followers'] : null;
        $employeeNew = !empty($dataPost['followingEmployees']) ? $dataPost['followingEmployees'] : null;
        return $this->_mergeData($employeeOld, $employeeNew);
    }

    /**
     * Function update or add info in table task_assignment of screen edit task
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _mergeDataTaskGroup($dataPost = []) {
        if (empty($dataPost))
            return false;

        $taskGroupOld = !empty($dataPost['data_old']['taskGroup']) ? $dataPost['data_old']['taskGroup'] : null;
        $taskGroupNew = !empty($dataPost['taskGroupIds']) ? $dataPost['taskGroupIds'] : null;

        $result = [];
        if (!empty($taskGroupOld) && !empty($taskGroupNew)) {
            foreach ($taskGroupOld as $keyTaskGroupOld => $valTaskGroupOld) {
                $result['taskGroupOld'][$keyTaskGroupOld] = $valTaskGroupOld;
                foreach ($taskGroupNew as $keyTaskGroupNew => $varTaskGroupNew) {
                    $result['taskGroupNew'][$keyTaskGroupNew] = $varTaskGroupNew;
                    if ($valTaskGroupOld == $varTaskGroupNew) {
                        unset($taskGroupOld[$keyTaskGroupOld]);
                        unset($taskGroupNew[$keyTaskGroupNew]);
                        unset($result['taskGroupOldLog'][$valTaskGroupOld]);
                        unset($result['taskGroupNewLog'][$varTaskGroupNew]);
                        unset($result['taskGroupOld'][$keyTaskGroupOld]);
                        unset($result['taskGroupNew'][$keyTaskGroupNew]);
                    }
                }
            }
        } else if (!empty($taskGroupOld) && empty($taskGroupNew)) {
            foreach ($taskGroupOld as $keyTaskGroupOld => $valTaskGroupOld) {
                $result['taskGroupOld'][$keyTaskGroupOld] = $valTaskGroupOld;
            }
        } else if (empty($taskGroupOld) && !empty($taskGroupNew)) {
            foreach ($taskGroupNew as $keyTaskGroupNew => $varTaskGroupNew) {
                $result['taskGroupNew'][$keyTaskGroupNew] = $varTaskGroupNew;
            }
        }
        return $result;
    }

    /**
     * Function update or add info in table project_participant of screen edit project
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _mergeData($employeeOld = null, $employeeNew = null) {
        $result = [];
        if (!empty($employeeOld) && !empty($employeeNew)) {
            foreach ($employeeOld as $keyEmployessOld => $valEmployeeOld) {
                $result['employeeOld'][$keyEmployessOld] = $valEmployeeOld['id'];
                $result['employeeOldLog'][$valEmployeeOld['id']] = $valEmployeeOld['fullname'];
                foreach ($employeeNew as $keyMemberNew => $valMemberNew) {
                    $result['employeeNew'][$keyMemberNew] = $valMemberNew['id'];
                    $result['employeeNewLog'][$valMemberNew['id']] = $valMemberNew['fullname'];
                    if ($valEmployeeOld['id'] == $valMemberNew['id']) {
                        unset($employeeOld[$keyEmployessOld]);
                        unset($employeeNew[$keyMemberNew]);
                        unset($result['employeeOldLog'][$valEmployeeOld['id']]);
                        unset($result['employeeNewLog'][$valMemberNew['id']]);
                        unset($result['employeeOld'][$keyEmployessOld]);
                        unset($result['employeeNew'][$keyMemberNew]);
                    }
                }
            }
        } else if (!empty($employeeOld) && empty($employeeNew)) {
            foreach ($employeeOld as $keyEmployessOld => $valEmployeeOld) {
                $result['employeeOld'][$keyEmployessOld] = $valEmployeeOld['id'];
                $result['employeeOldLog'][$valEmployeeOld['id']] = $valEmployeeOld['fullname'];
            }
        } else if (empty($employeeOld) && !empty($employeeNew)) {
            foreach ($employeeNew as $keyMemberNew => $valMemberNew) {
                $result['employeeNew'][$keyMemberNew] = $valMemberNew['id'];
                $result['employeeNewLog'][$valMemberNew['id']] = $valMemberNew['fullname'];
            }
        }
        return $result;
    }

    /**
     * Function update or add info in table project_participant of screen edit project
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _mergeDataEmployees($dataPost = []) {
        if (empty($dataPost))
            return false;

        $assigningEmployees = !empty($dataPost['assigningEmployees']) ? $dataPost['assigningEmployees'] : [];
        $followingEmployees = !empty($dataPost['followingEmployees']) ? $dataPost['followingEmployees'] : [];

        $assigning = !empty($dataPost['data_old']['assignees']) ? $dataPost['data_old']['assignees'] : [];
        $following = !empty($dataPost['data_old']['followers']) ? $dataPost['data_old']['followers'] : [];

        $employeeNew = array_merge($assigningEmployees, $followingEmployees);
        $employeeOld = array_merge($assigning, $following);

        $result = [];
        if (!empty($employeeOld) && !empty($employeeNew)) {
            foreach ($employeeOld as $keyEmployessOld => $valEmployeeOld) {
                $result['employeeOld'][$keyEmployessOld] = $valEmployeeOld['id'];
                foreach ($employeeNew as $keyMemberNew => $valMemberNew) {
                    $result['employeeNew'][$keyMemberNew] = $valMemberNew['id'];
                    $result['employees'][$keyMemberNew] = $valMemberNew['id'];
                    if ($valEmployeeOld['id'] == $valMemberNew['id']) {
                        unset($employeeOld[$keyEmployessOld]);
                        unset($employeeNew[$keyMemberNew]);
                        unset($result['employeeOld'][$keyEmployessOld]);
                        unset($result['employeeNew'][$keyMemberNew]);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Make project history
     *
     * @param array $dataPost
     * @return string
     */
    private function _makeTaskHistory($dataPost, $object) {
        $content = '';
        if (empty($dataPost)) {
            return $content;
        }

        $noSetting = \Yii::t('member', 'no setting');
        //get name project
        $project_id_old = !empty($dataPost['data_old']['task']['project_id']) ? $dataPost['data_old']['task']['project_id'] : 0;
        $project_id_new = !empty($dataPost['data_old']['project_id']) ? $dataPost['data_old']['project_id'] : 0;
        $project_name_old = $project_name_new = '';
        if ($project_id_old != $project_id_old) {
            $project = Project::find()
                    ->select(['id', 'name'])
                    ->where(['id' => [$project_id_old, $project_id_new]])
                    ->andCompanyId()
                    ->all();
            if (!empty($project)) {
                foreach ($project as $key => $val) {
                    if ($val->id == $project_id_old) {
                        $project_name_old = '#Task ' . $val->id . ': ' . $val->name;
                    }
                    if ($val->id == $project_id_new) {
                        $project_name_new = '#Task ' . $val->id . ': ' . $val->name;
                    }
                }
            }
        }

        $task_id_old = !empty($dataPost['data_old']['task']['parent_id']) ? $dataPost['data_old']['task']['parent_id'] : 0;
        $task_id_new = !empty($object->parent_id) ? $object->parent_id : 0;
        $task_name_old = $task_name_new = '';
        if ($task_id_old != $task_id_new) {
            $task = Task::find()
                    ->select(['id', 'name'])
                    ->where(['id' => [$dataPost['data_old']['task']['parent_id'], $object->parent_id]])
                    ->andCompanyId()
                    ->all();
            if (!empty($task)) {
                foreach ($task as $key => $val) {
                    if ($val->id == $task_id_old) {
                        $task_name_old = $val->name;
                    }
                    if ($val->id == $task_id_new) {
                        $task_name_new = $val->name;
                    }
                }
            }
        }

        $dataReplace = array(
            \Yii::t('member', 'task name') => array($dataPost['data_old']['task']['name'] => $dataPost['name']),
            \Yii::t('member', 'project name') => array($project_name_old => $project_name_new),
            \Yii::t('member', 'task end date') => array($dataPost['data_old']['task']['duedatetime'] => date('Y-m-d', $object->duedatetime)),
            \Yii::t('member', 'task priority') => array($dataPost['data_old']['task']['priority_name'] => $object->priority->name),
            \Yii::t('member', 'project completed percent') => array($dataPost['data_old']['task']['completed_percent'] => $object->completed_percent),
            \Yii::t('member', 'project description') => array($dataPost['data_old']['task']['description'] => $object->description),
            \Yii::t('member', 'project share') => array($dataPost['data_old']['task']['status_name'] => $object->status->name),
            \Yii::t('member', 'project estimate') => array($dataPost['data_old']['task']['estimate_hour'] => $object->estimate_hour),
            \Yii::t('member', 'project parent') => array($task_name_old => $task_name_new),
        );

        //Create log project history text.
        foreach ($dataReplace as $key => $value) {
            if (!empty($value)) {
                foreach ($value as $after => $befor) {
                    if ($after != $befor) {
                        $after = empty($after) ? \Yii::t('member', 'no setting') : $after;
                        $befor = empty($befor) ? \Yii::t('member', 'no setting') : $befor;
                        switch ($key) {
                            case \Yii::t('member', 'project description'):
                                $description = !empty($befor) ? \Yii::t('member', 'project description') . ' ' . \Yii::t('member', 'comment update after') . ' ' . $befor : $noSetting;
                                $content .= '<li>' . $description . '</li>';
                                break;
                            default:
                                $content .= '<li>' . str_replace(array('{{title}}', '{{after}}', '{{befor}}'), array($key, $after, $befor), \Yii::t('member', 'message info content')) . '</li>';
                                break;
                        }
                    }
                }
            }
        }

        //Create text log for files.
        if (!empty($dataPost['fileList'])) {
            $content .= '<li>' . \Yii::t('member', 'add file') . '</li>';
            foreach ($dataPost['fileList'] as $key => $file) {
                $content .= '<div class="padding-left-20"><i><a href="' . \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $file['path'] . '">' . $file['name'] . '</a></i></div>';
            }
        }

        //Create text log for employee and department.
        if (($project_id_old != $project_id_new)) {
            $assignmenMerge = $this->_mergeDataAssignmen($dataPost);
            if (!empty($assignmenMerge)) {
                if (!empty($assignmenMerge['employeeNewLog']) || !empty($assignmenMerge['employeeOldLog'])) {
                    $content .= '<li>' . \Yii::t('member', 'change employee followers') . '</li>';
                    if (!empty($assignmenMerge['employeeOldLog'])) {
                        $content .= '<div class="padding-left-20">' . \Yii::t('member', 'delete') . '</div>';
                        foreach ($assignmenMerge['employeeOldLog'] as $key => $val) {
                            $content .='<div class="padding-left-20"><a href="#/member/' . $key . '"><i>' . $val . '</i></a></div>';
                        }
                    }

                    if (!empty($assignmenMerge['employeeNewLog'])) {
                        $content .= '<div class="padding-left-20">' . \Yii::t('member', 'add new') . '</div>';
                        foreach ($assignmenMerge['employeeNewLog'] as $key => $val) {
                            $content .='<div class="padding-left-20"><a href="#/member/' . $key . '"><i>' . $val . '</i></a></div>';
                        }
                    }
                }
            }

            $followerMerge = $this->_mergeDataFollower($dataPost);
            if (!empty($followerMerge)) {
                if (!empty($followerMerge['employeeNewLog']) || !empty($followerMerge['employeeOldLog'])) {
                    $content .= '<li>' . \Yii::t('member', 'change employee assigners') . '</li>';
                    if (!empty($followerMerge['employeeOldLog'])) {
                        $content .= '<div class="padding-left-20">' . \Yii::t('member', 'delete') . '</div>';
                        foreach ($followerMerge['employeeOldLog'] as $key => $val) {
                            $content .='<div class="padding-left-20"><a href="#/member/' . $key . '"><i>' . $val . '</i></a></div>';
                        }
                    }

                    if (!empty($followerMerge['employeeNewLog'])) {
                        $content .= '<div class="padding-left-20">' . \Yii::t('member', 'add new') . '</div>';
                        foreach ($followerMerge['employeeNewLog'] as $key => $val) {
                            $content .='<div class="padding-left-20"><a href="#/member/' . $key . '"><i>' . $val . '</i></a></div>';
                        }
                    }
                }
            }

            $taskgroupMerge = $this->_mergeDataTaskGroup($dataPost);
            if (!empty($taskgroupMerge)) {
                if (!empty($taskgroupMerge['taskGroupNew']) || !empty($taskgroupMerge['taskGroupOld'])) {
                    $content .= '<li>' . \Yii::t('member', 'task group') . '</li>';
                    if (!empty($taskgroupMerge['taskGroupOld'])) {
                        $content .= '<div class="padding-left-20">' . \Yii::t('member', 'delete') . '</div>';

                        $taskGroups = TaskGroup::find()->select(['id', 'name'])->where(['id' => $taskgroupMerge['taskGroupOld']])->andCompanyId()->all();
                        foreach ($taskGroups as $key => $val) {
                            $content .='<div class="padding-left-20"><i>' . $val->name . '</i></div>';
                        }
                    }
                    if (!empty($taskgroupMerge['taskGroupNew'])) {
                        $content .= '<div class="padding-left-20">' . \Yii::t('member', 'add new') . '</div>';
                        $taskGroups = TaskGroup::find()->select(['id', 'name'])->where(['id' => $taskgroupMerge['taskGroupNew']])->andCompanyId()->all();
                        foreach ($taskGroups as $key => $val) {
                            $content .='<div class="padding-left-20"><i>' . $val->name . '</i></div>';
                        }
                    }
                }
            }
        }

        return $content == '' ? false : "<ul>" . $content . "</ul>";
    }

    /**
     * Get My task list show caledar.
     */
    public function actionGetMyTaskForCalendar() {
        $result = [];
        if ($tasks = Task::getMyTaskForCalendar()) {
            foreach ($tasks as $task) {
                $duedatetime = $task['duedatetime'] == null ? : $task['duedatetime'];
                $result[] = [
                    'id' => $task['id'],
                    'color' => "#00a65a",
                    'start' => date('Y-m-d'),
                    'end' => !empty($duedatetime) ? date('Y-m-d H:i:s', $duedatetime) : date('Y-m-d', $duedatetime),
                    'title' => 'Task: ' . $task['name'],
                    'isTask' => true,
                ];
            }
        }
        return $this->sendResponse(false, '', $result);
    }

    /**
     * Get my follow task list show caledar.
     */
    public function actionGetMyFollowTaskForCalendar() {
        $result = [];
        if ($tasks = Task::getMyFollowTaskForCalendar()) {
            foreach ($tasks as $task) {
                $duedatetime = $task['duedatetime'] == null ? : $task['duedatetime'];
                $result[] = [
                    'id' => $task['id'],
                    'color' => "#3b91ad",
                    'start' => date('Y-m-d'),
                    'end' => !empty($duedatetime) ? date('Y-m-d H:i:s', $duedatetime) : date('Y-m-d', $duedatetime),
                    'title' => 'Follow: ' . $task['name'],
                    'isTask' => true,
                ];
            }
        }

        return $this->sendResponse(false, '', $result);
    }

    /**
     * Get my follow task list show caledar.
     */
    public function actionGetReport($projectId = 0) {
        $result = [];
        if ($report = Task::getReport($projectId)) {
//            var_dump($report);die;
        }

        return $this->sendResponse(false, '', $report);
    }

}
