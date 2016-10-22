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

    /**
     * Get all of follow tasks that employee follow.
     * @param interger $itemPerPage
     * @param interger $currentPage
     * @param string $searchText
     * @return array|null
     */
    public static function getFollowTasks($itemPerPage, $currentPage, $searchText) {
        $follower = Follower::find()
                        ->select(['task_id'])
                        ->where(['employee_id' => \Yii::$app->user->identity->id])
                        ->andCompanyId()->asArray()->all();
        if (empty($follower)) {
            throw new \Exception('Get task_assigment empty');
        }

        $tasks = Task::find(['id', 'company_id', 'company_id', 'priority_id', 'status_id', 'parent_id', 'employee_id',
                            'name', 'description', 'description_parse', 'start_datetime', 'duedatetime', 'estimate_hour', 'worked_hour',
                            'completed_percent', 'is_public'])
                        ->with('creator', 'assignees', 'followers')
                        ->andWhere(['id' => array_map('current', $follower)])->andCompanyId();
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
     * @param interger $itemPerPage
     * @param interger $currentPage
     * @param string $searchText
     * @return array|null
     */
    public static function getMyTasks($itemPerPage, $currentPage, $searchText) {
        $taskAss = TaskAssignment::find()
                        ->select(['task_id'])
                        ->where(['employee_id' => \Yii::$app->user->identity->id])
                        ->andCompanyId()->asArray()->all();

        if (empty($taskAss)) {
            throw new \Exception('Get task_assigment empty');
        }

        $tasks = Task::find(['id', 'company_id', 'company_id', 'priority_id', 'status_id', 'parent_id', 'employee_id',
                            'name', 'description', 'description_parse', 'start_datetime', 'duedatetime', 'estimate_hour', 'worked_hour',
                            'completed_percent', 'is_public'])
                        ->with('creator', 'assignees', 'followers')
                        ->andWhere(['id' => array_map('current', $taskAss)])->andCompanyId();
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
        $tasks = self::find()
                        ->select(['task.id', 'task.name', 'task.description', 'completed_percent', 'task.created_employee_id'])
                        ->distinct()
                        ->leftJoin('task_assignment', 'task.id = task_assignment.task_id')
                        ->leftJoin('follower', 'task.id = follower.task_id')
                        ->orWhere([
                            'task.is_public' => self::VAL_TRUE,
                        ])->orWhere([
                    'task.created_employee_id' => \Yii::$app->user->identity->id,
                ])->orWhere([
                    'task_assignment.employee_id' => \Yii::$app->user->identity->id,
                ])->orWhere([
            'follower.employee_id' => \Yii::$app->user->identity->id,
        ])->andCompanyId(false, 'task');

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
}
