<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "task".
 *
 * @property string $id
 * @property string $company_id
 * @property string $project_id
 * @property string $priority_id
 * @property string $status_id
 * @property string $kpi_id
 * @property string $parent_id
 * @property string $employee_id
 * @property string $name
 * @property string $description
 * @property string $description_parse
 * @property string $start_datetime
 * @property string $duedatetime
 * @property string $estimate_hour
 * @property string $worked_hour
 * @property integer $completed_percent
 * @property boolean $is_public
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Task extends \common\components\db\ActiveRecord {

    public $sms = 0;
    //Status of task.
    const STATUS_COLUMN_NAME_COMPLETED = 'task.completed';
    const STATUS_COLUMN_NAME_INPROGRESS = 'task.inprogress';
    const STATUS_COLUMN_NAME_CLOSED = 'task.closed';

    function __construct($config = []) {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_id', 'project_id', 'priority_id', 'status_id', 'kpi_id', 'parent_id', 'employee_id', 'start_datetime', 'duedatetime', 'estimate_hour', 'worked_hour', 'completed_percent', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['name', 'description'], 'required'],
            [['description', 'description_parse'], 'string'],
            [['is_public', 'disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'project_id' => 'Project ID',
            'priority_id' => 'Priority ID',
            'status_id' => 'Status ID',
            'kpi_id' => 'Kpi ID',
            'parent_id' => 'Parent ID',
            'employee_id' => 'Employee ID',
            'name' => Yii:: t('common', 'Name'),
            'description' => Yii:: t('common', 'Description'),
            'description_parse' => 'Description Parse',
            'start_datetime' => 'Start Datetime',
            'duedatetime' => 'Duedatetime',
            'estimate_hour' => 'Estimate Hour',
            'worked_hour' => 'Worked Hour',
            'completed_percent' => 'Completed Percent',
            'is_public' => 'Is Public',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }

    public function getStatus() {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    public function getCreator() {
        return $this->hasOne(Employee::className(), ['id' => 'created_employee_id']);
    }

    public function getFollowers() {
        return $this->hasMany(Employee::className(), ['id' => 'employee_id'])->viaTable('follower', ['task_id' => 'id']);
    }

    public function getAssignees() {
        return $this->hasMany(Employee::className(), ['id' => 'employee_id'])->viaTable('task_assignment', ['task_id' => 'id']);
    }

    public function getCompany() {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getTaskGroups() {
        return $this->hasMany(TaskGroup::className(), ['project_id' => 'id']);
    }

    public function getTaskGroupAllocations() {
        return $this->hasMany(TaskGroupAllocation::className(), ['task_id' => 'id']);
    }
    
    /**
     * display info case is publuc
     */
    public function getIsPublic() {
        return $this->is_public == true ? Yii::t('member', 'event_is_public') : Yii::t('member', 'event_not_public');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriority() {
        return $this->hasOne(Priority::className(), ['id' => 'priority_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee() {
        return $this->hasOne(Employee::className(), ['id' => 'created_employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssigner() {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }
    
    /**
     * get parant task by parent id and project id
     * 
     * param integer $parentId
     * param integer $projectId
     * 
     * @return \yii\db\ActiveQuery
     */
    public static function getParent($parentId = null, $projectId = null) {
        if (empty($parentId) || empty($projectId)) {
            return false;
        }
        $taskParent = Task::find()->select(['id', 'name'])->where(['project_id' => $projectId, 'id' => $parentId])->one();
        if (empty($taskParent)) {
            return null;
        }
        return $taskParent;
    }

    /**
     * Get children task by $taskId and current task url
     * 
     * param integer $taskId
     * param integer $projectId
     * 
     * @return \yii\db\ActiveQuery
     */
    public static function getChildren($taskId = null, $projectId = null) {
        if (empty($taskId) || empty($projectId)) {
            return false;
        }
        $taskChildren = Task::find()->select(['id', 'name'])->where(['project_id' => $projectId, 'parent_id' => $taskId])->all();
        if (empty($taskChildren)) {
            return null;
        }
        return $taskChildren;
    }


    /**
     * Get all of follow tasks that employee follow.
     * 
     * @param interger $itemPerPage
     * @param interger $currentPage
     * @param string $searchText
     * @return array|null
     */
    public static function getFollowTasks($itemPerPage, $currentPage, $searchText) {
        $subFollowQuery = Follower::find()
                ->select('task_id')
                ->where(['employee_id' => \Yii::$app->user->identity->id]);

        $tasks = Task::find(['id', 'company_id', 'company_id', 'priority_id', 'status_id', 'parent_id', 'employee_id',
                            'name', 'description', 'description_parse', 'start_datetime', 'duedatetime', 'estimate_hour', 'worked_hour',
                            'completed_percent', 'is_public'])
                        ->with('creator', 'assignees', 'followers')
                        ->andWhere(['id' => $subFollowQuery])->andCompanyId();
        
        if ($searchText) {
            $tasks->andFilterWhere(['like', 'name', $searchText]);
        }

        $totalCount = $tasks->count();
        $tasks = $tasks->orderBy('datetime_created DESC')
                        ->limit($itemPerPage)->offset(($currentPage - 1) * $itemPerPage)->all();
        if (empty($tasks)) {
            throw new \Exception('Get task empty');
        }

        return [
            'collection' => $tasks,
            'totalCount' => $totalCount,
        ];
    }

    /**
     * Get all of tasks that employee is assigned.
     * 
     * @param interger $itemPerPage
     * @param interger $currentPage
     * @param string $searchText
     * @return array|null
     */
    public static function getMyTasks($itemPerPage, $currentPage, $searchText) {
        $subTaskAssiQuery = TaskAssignment::find()
                ->select('task_id')
                ->where(['employee_id' => \Yii::$app->user->identity->id]);

        $tasks = self::find(['id', 'company_id', 'company_id', 'priority_id', 'status_id', 'parent_id', 'employee_id',
                            'name', 'description', 'description_parse', 'start_datetime', 'duedatetime', 'estimate_hour', 'worked_hour',
                            'completed_percent', 'is_public'])
                        ->with('creator', 'assignees', 'followers')
                        ->andWhere(['id' => $subTaskAssiQuery])->andCompanyId();

        if ($searchText) {
            $tasks->andFilterWhere(['like', 'name', $searchText]);
        }

        $totalCount = $tasks->count();
        $tasks = $tasks->orderBy('datetime_created DESC')
                        ->limit($itemPerPage)->offset(($currentPage - 1) * $itemPerPage)->all();
        if (empty($tasks)) {
            throw new \Exception('Get task empty');
        }

        return [
            'collection' => $tasks,
            'totalCount' => $totalCount,
        ];
    }    
    
    /**
     * Get all of tasks that employee who can be able to see.
     * @param interger $itemPerPage
     * @param interger $currentPage
     * @param string $searchText
     * @return array|null
     */
    public static function getTasks($itemPerPage, $currentPage, $searchText) {
        $subFollowQuery = Follower::find()->select('task_id')->where(['employee_id' => \Yii::$app->user->identity->id]);
        $subTaskAssiQuery = TaskAssignment::find()->select('task_id')->where(['employee_id' => \Yii::$app->user->identity->id]);
        $tasks = self::find()
                        ->select(['task.id', 'task.name', 'task.description', 'completed_percent', 'task.created_employee_id'])
                        ->orWhere([
                            'task.is_public' => self::VAL_TRUE,
                        ])->orWhere([
                    'task.created_employee_id' => \Yii::$app->user->identity->id,
                ])->orWhere([
                    'task.id' => $subFollowQuery,
                ])->orWhere([
                    'task.id' => $subTaskAssiQuery,
                ])->andCompanyId();

        if ($searchText) {
            $tasks->andFilterWhere(['like', 'name', $searchText]);
        }

        $totalCount = $tasks->count();
        $tasks = $tasks->orderBy('task.datetime_created DESC')->limit($itemPerPage)
                ->offset(($currentPage - 1) * $itemPerPage)
                ->all();
        if (empty($tasks)) {
            return [];
        }

        return [
            'collection' => $tasks,
            'totalCount' => $totalCount,
        ];
    }

    /**
     * Get Event information by id
     *
     * @param integer $eventId
     * @return array
     */
//    public static function getById($id) {
//        return Task::find()->where(['id' => $id])->one();
//    }

    /**
     * Get Info task
     * 
     * @param $taskId
     * @return array
     */
    public static function getInfoTask($taskId = null){
        if ($taskId == null) {
            return null;
        }
        //get Id company of user login
        $companyId = \Yii::$app->user->getCompanyId();
        //disable = 0/////////////
        $task = Task::findOne(['id' => $taskId, 'company_id' => $companyId]);
        if (empty($task)) {
            return false;
        }
        
        //Get parent tasks:
        $parentTask = self::getParent($task->parent_id, $task->project_id);
        if (!empty($parentTask)) {
            $parentTask = ['id' => $parentTask->id, 'name' => $parentTask->name];
        }
        
        //Get children tasks:
        $childrens = self::getChildren($task->id, $task->project_id);
        $childrenList = [];
        if (!empty($childrens)) {
            foreach ($childrens as $key => $val) {
                $childrenList[] =  ['id' => $val->id, 'name' => $val->name];
            }
        }
        
        //Get file list.
        $fileList = File::getFileByOwnerIdAndTable($taskId, self::tableName());
        $theory = $task->estimate_hour > 0 ? ((int) (($task->worked_hour / $task->estimate_hour) * 100)) : 0;
        $startDateTime = !empty($task->start_datetime) ? date('Y-m-d', $task->start_datetime) : null;
        $duedatetime   = !empty($task->duedatetime)    ? date('Y-m-d', $task->duedatetime) : null;
        $creatorTask = [
                'id'         => $task->created_employee_id,
                'image'      => !empty($task->employee) ? $task->employee->getImage() : null,
                'fullname'  => !empty($task->employee) ? $task->employee->getFullName() : null,
        ];
        
        $assigner = [
                'id'         => $task->employee_id,
                'image'      => !empty($task->assigner) ? $task->assigner->getImage() : null,
                'fullname'  => !empty($task->assigner) ? $task->assigner->getFullName() : null,
        ];
        
        //Use to check whether or not employee to view task.
        $assignView = false;
        // get followed employees via follower table.
        $followers = [];
        if ($task->followers) {
            foreach ($task->followers as $follower) {
                $followers[] = ['id' => $follower->id, 'fullname' => $follower->fullname, 'image' => $follower->getImage(), 'email' => $follower->email];
                if ($follower->id == \Yii::$app->user->getId()) {
                    $assignView = true;
                }
            }
        }
        
        $assignees = [];
        if ($task->assignees) {
            foreach ($task->assignees as $assignee) {
                $assignees[] = ['id' => $assignee->id, 'fullname' => $assignee->fullname, 'image' => $assignee->getImage(), 'email' => $assignee->email];
                if ($assignee->id == \Yii::$app->user->getId()) {
                    $assignView = true;
                }
            }
        }
        //get remind by owner id
        $remind = Remind::getByOwnerIdAndOwnerTable($taskId, Task::tableName());

        //get list task group
        $taskGroups = [];
        foreach ($task->taskGroupAllocations AS $taskgroup){
            if (!empty($taskgroup->taskgroups)) {
                $taskGroups[$taskgroup->taskgroups->id] = $taskgroup->taskgroups->id;
            }
        }

        $result = [
                'task' => [
                        'id'                => $task->id,
                        'name'              => $task->name,
                        'kpi_id'            => $task->kpi_id,
                        'theory'            => $theory,
                        'parent_id'         => $task->parent_id,
                        'is_public'         => $task->is_public,
                        'status_id'         => $task->status_id,
                        'created_by'        => $creatorTask,
                        'project_id'        => $task->project_id,
                        'priority_id'       => $task->priority_id,
                        'employee_id'       => $task->employee_id,
                        'description'       => $task->description,
                        'worked_hour'       => $task->worked_hour,
                        'duedatetime'       => $duedatetime,
                        'status_name'       => $task->status->name,
                        'priority_name'     => $task->priority->name,
                        'estimate_hour'     => $task->estimate_hour,
                        'start_datetime'    => $startDateTime,
                        'is_public_name'    => $task->getIsPublic(),
                        'completed_percent' => $task->completed_percent,
                        'description_parse' => $task->description_parse,
                        'creator_event_id'  => $task->created_employee_id,
                        'remind'        => isset($remind->minute_before) ? $remind->minute_before : null,
                ],
                'file_info'     => $fileList,
                'parentTask'   => $parentTask,
                'childrenList' => $childrenList,
                'assigner' => $assigner,
                'followers' => $followers,
                'taskGroup' => array_values($taskGroups),
                'assignees' => $assignees,
                'employeeList' => array_merge($followers,$assignees),
                'assignView' => $assignView
        ];
        
        return $result;
    }
    
    /**
     * Get tasks by project id.
     * @param interger $projectId
     * @return array|null
     */
    public static function getByProjectId($projectId) {
        return self::find()
                        ->select(['id', 'name'])
                        ->where(['project_id' => \Yii::$app->request->get('project_id')])
                        ->andCompanyId()
                        ->orderBy('datetime_created DESC')
                        ->asArray()
                        ->all();
    }

    /**
     * Get list task of employees login
     */
    public static function getMyTaskForCalendar() {
        $subTaskAssiQuery = TaskAssignment::find()
                ->select('task_id')
                ->where(['employee_id' => \Yii::$app->user->identity->id]);

        return self::find()
                        ->select(['task.id', 'task.name', 'task.start_datetime', 'task.duedatetime'])
                        ->leftJoin('status', 'task.status_id=status.id')
                        ->andWhere(['task.id' => $subTaskAssiQuery])
                        ->andWhere(['not in', Status::tableName() . '.column_name', [self::STATUS_COLUMN_NAME_COMPLETED, self::STATUS_COLUMN_NAME_CLOSED]])
                        ->andCompanyId(false, 'task')
                        ->orderBy('task.datetime_created DESC')
                        ->asArray()
                        ->all();
    }

    /**
     * Get all task follow employess login
     */
    public static function getMyFollowTaskForCalendar() {
        $subFollowQuery = Follower::find()
                ->select('task_id')
                ->where(['employee_id' => \Yii::$app->user->identity->id]);

        return self::find()
                        ->select(['task.id', 'task.name', 'task.start_datetime', 'task.duedatetime'])
                        ->leftJoin('status', 'task.status_id=status.id')
                        ->andWhere(['task.id' => $subFollowQuery])
                        ->andWhere(['not in', Status::tableName() . '.column_name', [self::STATUS_COLUMN_NAME_COMPLETED, self::STATUS_COLUMN_NAME_CLOSED]])
                        ->andCompanyId(false, 'task')
                        ->orderBy('task.datetime_created DESC')
                        ->asArray()
                        ->all();
    }

    /**
     * Get list task of employees login
     * @param interger $currentPage
     * @param interger $itemPerPage
     * @return array
     */
    public static function getMyTaskForDropdown($currentPage = 1, $itemPerPage = 10) {
        $subTaskAssiQuery = TaskAssignment::find()
                    ->select('task_id')
                    ->where(['employee_id' => \Yii::$app->user->identity->id]);

        $myTasks = self::find()
                    ->select(['task.id', 'task.name', 'completed_percent'])
                    ->leftJoin('status', 'task.status_id=status.id')
                    ->andWhere(['task.id' => $subTaskAssiQuery])
                    ->andWhere(['not in', Status::tableName() . '.column_name', [self::STATUS_COLUMN_NAME_COMPLETED, self::STATUS_COLUMN_NAME_CLOSED]])
                    ->andCompanyId(false, 'task')
                    ->orderBy('task.datetime_created DESC');
        
        $totalCount = $myTasks->count();
        $myTasks = $myTasks->offset(($currentPage - 1) * $itemPerPage)
                    ->limit($itemPerPage)
                    ->asArray()
                    ->all();
        
        return [
            'collection' => $myTasks,
            'totalCount' => $totalCount,
        ];
    }    
        
    /**
     * Get all task follow employess login
     */
    public static function getReport($projectId) {
        $report =  self::find()
                        ->select(['COUNT(task.id) AS number_task', 'status.column_name', 'translation.translated_text AS status_name'])
                        ->leftJoin('status', 'task.status_id=status.id AND status.owner_table="task"');
        
        if ($projectId) {
            $report = $report->andFilterWhere(['task.project_id' => $projectId]);
        }
                        
        return $report->leftJoin('translation', 'translation.owner_id=status.id AND translation.owner_table="status"')
                ->leftJoin('language', 'translation.language_id=language.id')
                ->andWhere(['language.language_code' => \Yii::$app->language])
                ->andCompanyId(false, 'task')
                ->groupBy(['status_id'])
                ->asArray()
                ->all();
        
//        print($a->createCommand()->RawSql);die;
    }
}
