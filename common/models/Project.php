<?php

namespace common\models;

use Yii;
use common\models\ProjectEmployee;

/**
 * This is the model class for table "project".
 *
 * @property string $id
 * @property string $company_id
 * @property string $manager_project_id
 * @property integer $priority_id
 * @property integer $status_id
 * @property string $parent_id
 * @property string $name
 * @property string $description
 * @property string $description_parse
 * @property string $start_datetime
 * @property string $duedatetime
 * @property integer $completed_percent
 * @property integer $estimate_hour
 * @property integer $worked_hour
 * @property boolean $is_public
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Project extends \common\components\db\ActiveRecord {

    public $sms = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['priority_id', 'status_id', 'parent_id', 'name', 'description', 'description_parse'], 'required', 'message' => Yii::t('member', 'validate_required')],
            [['company_id', 'manager_project_id', 'priority_id', 'status_id', 'parent_id', 'completed_percent', 'estimate_hour', 'worked_hour', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer', 'message' => Yii::t('member', 'validate_integer')],
            [['description', 'description_parse'], 'string', 'message' => Yii::t('member', 'validate_string')],
            [['is_public', 'disabled'], 'boolean', 'message' => Yii::t('member', 'validate_boolean')],
            [['name'], 'string', 'max' => 255, 'tooLong' => Yii::t('member', 'validate_max_length')],
            [['start_datetime', 'duedatetime', 'sms'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company id',
            'manager_project_id' => Yii::t('member', 'project manager'),
            'priority_id' => Yii::t('member', 'project priority'),
            'status_id' => Yii::t('member', 'project status'),
            'parent_id' => Yii::t('member', 'project parent'),
            'name' => Yii::t('member', 'project name'),
            'description' => Yii::t('member', 'project description'),
            'description_parse' => Yii::t('member', 'project description parse'),
            'start_datetime' => Yii::t('member', 'project start'),
            'duedatetime' => Yii::t('member', 'project end'),
            'completed_percent' => Yii::t('member', 'project completed percent'),
            'estimate_hour' => Yii::t('member', 'project estimate'),
            'worked_hour' => Yii::t('member', 'project work'),
            'is_public' => Yii::t('member', 'project public'),
            'datetime_created' => Yii::t('member', 'created date'),
            'lastup_datetime' => Yii::t('member', 'last date'),
            'lastup_employee_id' => Yii::t('member', 'employee id'),
            'disabled' => Yii::t('member', 'disabled'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus() {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
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
        return $this->hasOne(Employee::className(), ['id' => 'manager_project_id']);
    }

    /**
     * Get all of projects that employee who can be able to see.
     * @param interger $itemPerPage
     * @param interger $offset
     * @return array|null
     */
    public static function getProjects($itemPerPage = 10, $offset = 0) {
        $subProjEmp = ProjectEmployee::find()->select('project_id')->where(['employee_id' => \Yii::$app->user->identity->id]);
        $projects = self::find()
                        ->select(['project.id', 'project.name', 'project.description_parse', 'project.status_id',
                            'project.completed_percent', 'project.worked_hour', 'project.estimate_hour', 'status.name as status_name'])
                        ->joinWith('status')
                        ->orWhere([
                            'project.is_public' => self::VAL_TRUE,
                        ])->orWhere([
                    'project.created_employee_id' => \Yii::$app->user->identity->id,
                ])->orWhere([
                    'project.manager_project_id' => \Yii::$app->user->identity->id,
                ])->orWhere([
                    'project.id' => $subProjEmp,
                ])->andCompanyId(false, self::tableName());


        $totalCount = $projects->count();
        $projects = $projects->orderBy('project.datetime_created DESC')->limit($itemPerPage)
                ->offset($offset)
                ->asArray()
                ->all();
        if (empty($projects)) {
            return [
                'collection' => [],
                'totalCount' => 0,
            ];
        }

        return [
            'collection' => $projects,
            'totalCount' => $totalCount,
        ];
    }

    /**
     * Get lasted project
     * @return array|null
     */
    public function getLastedProject() {
        $subProjEmp = ProjectEmployee::find()->select('project_id')->where(['employee_id' => \Yii::$app->user->identity->id]);
        $project = Project::find()
                        ->select(['project.id', 'project.name', 'project.description_parse', 'project.status_id',
                            'project.completed_percent', 'project.worked_hour', 'project.estimate_hour', 'status.name as status_name'])
                        ->joinWith('status')
                        ->orWhere([
                            'project.is_public' => self::VAL_TRUE,
                        ])->orWhere([
                    'project.created_employee_id' => \Yii::$app->user->identity->id,
                ])->orWhere([
                    'project.manager_project_id' => \Yii::$app->user->identity->id,
                ])->orWhere([
                    'project.id' => $subProjEmp,
                ])->andCompanyId(false, self::tableName());

        $project = $project->orderBy('project.datetime_created DESC')->asArray()->one();
        if (empty($project)) {
            return [];
        }
        
        return $project;
    }

    /**
     * Get project info by project id
     * 
     * @param int $projectId 
     * @return boolean|array
     */
    public static function getInfoProject($projectId) {
        $companyId = \Yii::$app->user->getCompanyId();
        $participants = $departmentNames = $employeeList = $projectManager = $employeeList = $employeeEditList = [];

        $project = Project::findOne(['id' => $projectId, 'company_id' => $companyId]);
        if (empty($project)) {
            return false;
        }

        //Get file with where: project_id, company_id, owner_table=project
        $fileList = File::getFileByOwnerIdAndTable($projectId, File::TABLE_PROJECT);

        //Department: inner join project_participant with department where project_id, company_id, owner_table=department.
        $projectParticipants = ProjectParticipant::getListByProjectId($projectId);
        if (!empty($projectParticipants)) {
            $departmentNames = empty($projectParticipants['department']) ? [] : $projectParticipants['department'];
            $participants = empty($projectParticipants['owner_table']) ? [] : $projectParticipants['owner_table'];
        }

        // * Get employee information in employee table with where = employee_id or department_id
        $employeeIds = isset($participants['employee']) ? $participants['employee'] : null;
        $departmentIds = isset($participants['department']) ? $participants['department'] : null;
        $employees = Employee::getlistByepartmentIdsAndEmployeeIds($departmentIds, $employeeIds);
        if (!empty($employees)) {
            $employeeList = empty($employees['employeeList']) ? [] : $employees['employeeList'];
            $employeeEditList = empty($employees['employeeEditList']) ? [] : $employees['employeeEditList'];
        }

        $projectParent = Project::findOne($project->parent_id);

        //Get status corresponding status and priority name for project.
        $priority = Priority::getByPriorityIdAndOwnerTable($project->priority_id, 'project');
        $status = Status::getByStatusIdAndOwnerTable($project->status_id, 'project');
        return [
            'project_info' => [
                'project_id' => $project->id,
                'project_name' => $project->name,
                'project_main' => empty($projectParent) ? '' : $projectParent->name,
                'project_manager' => isset($project->employee) ? $project->employee->getFullName() : '',
                'manager_project_id' => $project->manager_project_id,
                'image' => isset($project->employee) ? $project->employee->getImage() : null,
                'priority_id' => $project->priority_id,
                'priority_name' => !empty($priority['name']) ? $priority['name'] : '',
                'status_id' => $project->status_id,
                'status_name' => !empty($status['name'])?  $status['name'] : '',
                'completed_percent' => $project->completed_percent,
                'estimate_hour' => $project->estimate_hour,
                'is_public' => $project->is_public,
                'profile_image_path' => isset($project->employee->profile_image_path) ? $project->employee->profile_image_path : 'profileImageDefault.jpg',
                'start_datetime' => isset($project->start_datetime) ? date('Y-m-d', $project->start_datetime) : null,
                'duedatetime' => isset($project->duedatetime) ? date('Y-m-d', $project->duedatetime) : null,
                'theory' => $project->estimate_hour > 0 ? ((int) (($project->worked_hour / $project->estimate_hour) * 100)) : 0,
                'description' => $project->description,
            ],
            'file_info' => $fileList,
            'department_info' => empty($departmentNames) ? [] : $departmentNames,
            'employee_info' => $employeeList,
            'project_manager' => $projectManager,
            'participant_employee' => $employeeEditList,
        ];
    }

//   public function getEmployees() {
//        $projectParticipantModel = new ProjectParticipant();
//        $employees = $projectParticipantModel->getEmployeesByProjectId($this->id);        
//                
//        return $employees;
//    }

    public function getTasks() {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }

    public function getCompany() {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * Get id and name projects
     * @return boolean|array
     */
    public static function getIdAndNameProjects() {
        return self::find()
                        ->select(['id', 'name'])
                        ->andCompanyId()
                        ->orderBy('datetime_created DESC')
                        ->asArray()
                        ->all();
    }

}
