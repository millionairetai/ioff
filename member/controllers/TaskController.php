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

class TaskController extends ApiController {
    /*
     *  sms only 3 but 4
     * sms not write t db.
     * 
     */

    public function actionAdd() {
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

            if (!$task->save()) {
                $this->_message = $this->parserMessage($ob->getErrors());
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

            $employeeActivity->activity_task += 1;
            $employeeActivity->activity_total += 1;
            if (!$employeeActivity->save()) {
                throw new \Exception('Save record to employee_activity table fail');
            }

            $taskGroupAllocation = [];
            if (!empty($postData['taskGroupIds'])) {
                foreach ($postData['taskGroupIds'] as $taskGroupId) {
                    $taskGroupAllocation[] = [$task->id, $taskGroupId,];
                }
            }

            $employees = Employee::find()->select([Employee::tableName() . '.id', Employee::tableName() . '.email', 'firstname', 'lastname'])
                    ->where([Employee::tableName() . '.id' => array_merge($aAssignedEmployeeIds, $aFollowedEmployeeIds)])
                    ->andCompanyId()
                    ->all();

            $sms = [];
            $remind = [];
            $notifications = [];
            $noContent = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $task->name;
            foreach ($employees as $employee) {
                //notification
                $notifications[] = [$task->id, Notification::TABLE_TASK, $employee->id, \Yii::$app->user->getId(), "create_task", $noContent];

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
                if ($task->sms) {
                    $sms[] = [$task->id, $employee->id, \common\models\Sms::TABLE_TASK, $noContent, 1, 0];
                    //send sms
                    $employee->sendSms($dataSend, $themeSms);
                }

                //remind
                if (!empty($postData['redmind'])) {
                    $remind[] = [$employee->id, $task->id, Remind::TABLE_TASK, $task->name, $task->duedatetime - ($postData['redmind'] * 60), $postData['redmind'], 0, 0];
                }
            }//end foreach employees

            if (!empty($taskAss)) {
                if (!Yii::$app->db->createCommand()->batchInsert(
                                TaskAssignment::tableName(), ['task_id', 'employee_id'], $taskAss)->execute()) {
                    throw new \Exception('BatchInsert to task_assignment table fail');
                }
            }

            if (!empty($taskFollow)) {
                if (!Yii::$app->db->createCommand()->batchInsert(
                                Follower::tableName(), ['task_id', 'employee_id'], $taskFollow)->execute()) {
                    throw new \Exception('BatchInsert to follower table fail');
                }
            }

            if (!empty($taskGroupAllocation)) {
                if (!Yii::$app->db->createCommand()->batchInsert(
                                TaskGroupAllocation::tableName(), ['task_group_id', 'task_id'], $taskGroupAllocation)->execute()) {
                    throw new \Exception('BatchInsert to task_group_allocation table fail');
                }
            }

            if (!empty($notifications)) {
                if (!Yii::$app->db->createCommand()->batchInsert(
                                Notification::tableName(), ['owner_id', 'owner_table', 'employee_id', 'owner_employee_id', 'type', 'content'], $notifications)->execute()) {
                    throw new \Exception('BatchInsert to notification table fail');
                }
            }

            if (!empty($remind)) {
                if (!Yii::$app->db->createCommand()->batchInsert(
                                Remind::tableName(), ['employee_id', 'owner_id', 'owner_table', 'content', 'remind_datetime', 'minute_before', 'repeated_time', 'is_snoozing'], $remind)->execute()) {
                    throw new \Exception('BatchInsert to remind table fail');
                }
            }

            if (!empty($sms)) {
                if (!Yii::$app->db->createCommand()->batchInsert(
                                Sms::tableName(), ['owner_id', 'employee_id', 'owner_table', 'content', 'is_success', 'fee'], $sms)->execute()) {
                    throw new \Exception('BatchInsert to sms table fail');
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

        return $this->sendResponse($this->_error, $this->_message, $objects);
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
    public function actionGetAssignedTasks() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $search_text = \Yii::$app->request->get('searchText');
        try {
            $taskAss = TaskAssignment::find()
                            ->select(['task_id'])
                            ->where(['employee_id' => \Yii::$app->user->identity->id])
                            ->andCompanyId()->asArray()->all();
            if (empty($taskAss)) {
                throw new \Exception('Get task_assigment empty');
            }

            $tasks = Task::find()->andWhere(['id' => array_map('current', $taskAss)])->andCompanyId();
            if ($search_text) {
                $tasks->andFilterWhere(['like', 'name', $search_text]);
            }

            $totalCount = $tasks->count();
            $tasks = $tasks->limit($itemPerPage)->offset(($currentPage - 1) * $itemPerPage)->all();
            if (empty($tasks)) {
                throw new \Exception('Get task empty');
            }

            $assignees = [];
            $followers = [];
            $collection = [];
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
     * Get task list assigned for currrent login employee.
     */
    public function actionGetFollowTasks() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $search_text = \Yii::$app->request->get('searchText');
        try {
            $taskAss = Follower::find()
                            ->select(['task_id'])
                            ->where(['employee_id' => \Yii::$app->user->identity->id])
                            ->andCompanyId()->asArray()->all();
            if (empty($taskAss)) {
                throw new \Exception('Get task_assigment empty');
            }

            $tasks = Task::find()->andWhere(['id' => array_map('current', $taskAss)])->andCompanyId();
            if ($search_text) {
                $tasks->andFilterWhere(['like', 'name', $search_text]);
            }

            $totalCount = $tasks->count();
            $tasks = $tasks->limit($itemPerPage)->offset(($currentPage - 1) * $itemPerPage)->all();
            if (empty($tasks)) {
                throw new \Exception('Get task empty');
            }

            $assignees = [];
            $followers = [];
            $collection = [];
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

//    public function actionGetAssignedTasks1() {
//        $employeeId = \Yii::$app->user->getId();
//        $itemPerPage = \Yii::$app->request->get('count');
//        $currentPage = \Yii::$app->request->get('page');
//        $search_text = \Yii::$app->request->get('search_text');
//        $employee = new Employee(['id' => $employeeId]);
//
//        $query = $employee->getAssignedTasks();
//
//        if ($search_text) {
//            $query->andFilterWhere(['like', 'name', $search_text]);
//        }
//
//        $totalCount = $query->count();
//
//        $tasks = $query
//                        ->with(['assignees' => function ($query) {
////                    $query->select([Employee::tableName().'.firstname',Employee::tableName().'.email',Employee::tableName().'.profile_image_path']);
//                            }])
//                        ->with(['creator' => function ($query) {
////                    $query->select([Employee::tableName().'.firstname',Employee::tableName().'.email',Employee::tableName().'.profile_image_path']);
//                            }])
//                        ->with(['followers' => function ($query) {
////                    $query->select([Employee::tableName().'.firstname',Employee::tableName().'.email',Employee::tableName().'.profile_image_path']);
//                            }])
//                        ->limit($itemPerPage)->offset(($currentPage - 1) * $itemPerPage)->all();
////        echo $query->createCommand()->sql;die();
//        $collection = [];
//
//        foreach ($tasks as $task) {
//            $creator = $task->creator;
//            $assignees = [];
//            $followers = [];
////            var_dump($task->id);
////            if(empty($task->creator)) {
////                var_dump($task->id);
////                var_dump($task->creator);die;
////            }
//            foreach ($task->assignees as $assignee) {
//                $assignees[] = ['firstname' => $assignee->firstname, 'email' => $assignee->email, 'image' => $assignee->getImage()];
//            }
//
//            foreach ($task->followers as $follower) {
//                $followers[] = ['firstname' => $follower->firstname, 'email' => $follower->email, 'image' => $follower->getImage()];
//            }
//
//            $collection[] = [
//                'id' => $task->id,
//                'name' => $task->name,
//                'description' => strlen($task->description) > 70 ? (substr($task->description, 0, 70) . "...") : $task->description,
//                'creator' => ['firstname' => $creator->firstname, 'email' => $creator->email, 'image' => $creator->getImage()],
//                'followers' => $followers,
//                '$assignees' => $assignees,
//            ];
////            var_dump($task->followers);die;
//        }
//
//
////                exit();
//
//        $objects = [];
//        $objects['collection'] = $collection;
//        //total count
//        $objects['totalCount'] = (int) $totalCount;
//
//        return $this->sendResponse(FALSE, '', $objects);
//    }

}
