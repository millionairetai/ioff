<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property string $id
 * @property integer $company_id 
 * @property string $owner_id
 * @property string $owner_table
 * @property string $employee_id
 * @property string $parent_employee_id
 * @property string $type
 * @property string $content
 * @property integer $total_comment
 * @property integer $total_like
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Activity extends \common\components\db\ActiveRecord
{
    //const for owner table.
    const TABLE_PROJECT = "project";  
    const TABLE_EVENT = "event"; 
    const TABLE_TASK = "task"; 
    const TABLE_EMPLOYEE = "employee"; 
    
    //const for type of activity
    const TYPE_CREATE_TASK = 'create_task';
    const TYPE_EDIT_TASK   = 'edit_task';
    const TYPE_CREATE_TASK_POST   = 'create_task_post';
    const TYPE_CREATE_EVENT = 'create_event';
    const TYPE_EDIT_EVENT   = 'edit_event';
    const TYPE_CREATE_EVENT_POST = 'create_event_post';
    const TYPE_CREATE_PROJECT = 'create_project';
//    const TYPE_CREATE_EDIT_PROJECT = 'edit_project';
    const TYPE_EDIT_PROJECT = 'edit_project';
    const TYPE_CREATE_PROJECT_POST = 'create_project_post';
    const TYPE_REGISTER_ACCOUNT = 'register_account';
    const TYPE_ADD_ACCOUNT = 'add_account';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'owner_table', 'employee_id', 'type'], 'required'],
            [['company_id','total_comment', 'total_like','owner_id', 'employee_id', 'parent_employee_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['content'], 'string'],
            [['disabled'], 'boolean'],
            [['owner_table'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 99]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'owner_id' => 'Owner ID',
            'owner_table' => 'Owner Table',
            'employee_id' => 'Employee ID',
            'parent_employee_id' => 'Parent Employee ID',
            'type' => 'Type',
            'content' => 'Content',
            'total_comment' => 'Total comment',
            'total_like' => 'Total like',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    /**
     * Make content for activity
     * 
     * @param string $info
     * @return string
     */
    public static function makeContent($type, $info) {
        return \Yii::$app->user->identity->firstname . " " .$type . " " . $info;
    }
    
    /**
     * Get acitivity wall by employee id for employee
     * 
     * @param integer $employeeId
     * @return array
     */
    public static function getActivityWallByEmployeeId($employeeId, $offset, $perPage = 10) {
        $companyId = Yii::$app->user->identity->company_id;
        $sql = " SELECT SQL_CALC_FOUND_ROWS employee.id AS employee_id, employee.firstname, employee.lastname, employee.profile_image_path,  " 
            .  " activity.id AS activity_id, activity.`type`, activity.owner_table ,activity.`total_comment`, activity.`total_like`, activity.datetime_created,"
            .  " task.id AS task_id, task.name AS task_name, task.description_parse AS task_description_parse,"
            .  " project.id AS project_id, project.name AS project_name, project.description_parse AS project_description_parse,"
            .  " event.id AS event_id, event.name AS event_name, event.description_parse AS event_description_parse, event.start_datetime AS event_start_datetime, "
            .  " event.end_datetime AS event_end_datetime, event.is_all_day, "  
            .  " employee_owner.department_id, employee_owner.firstname AS new_employeee_firstname, employee_owner.lastname AS new_employeee_lastname, employee_owner.profile_image_path AS new_employeee_profile_image_path, employee_owner.id AS new_employeee_id, "
            .  " p_project.name AS p_project_name, p_project.id AS p_project_id"    
            .  " FROM activity "
            .  "     LEFT JOIN employee "
            .  "         ON activity.employee_id = employee.id AND employee.disabled = 0 "
            .  "     LEFT JOIN task "  
            .  "         ON activity.owner_id = task.id AND activity.owner_table='task' AND (task.is_public=1 OR EXISTS(SELECT task_id FROM task_assignment WHERE task_id=task.id AND task_assignment.employee_id={$employeeId}) OR EXISTS(SELECT task_id FROM follower WHERE task_id=task.id AND follower.employee_id={$employeeId})) AND task.disabled = 0 "
            .  "     LEFT JOIN project "
            .  "         ON activity.owner_id = project.id AND activity.owner_table='project' AND (project.is_public=1 OR EXISTS(SELECT project_id FROM project_employee WHERE project_id=project.id AND project_employee.employee_id={$employeeId})) AND project.disabled=0 "
            .  "     LEFT JOIN event "
            .  "         ON activity.owner_id = event.id AND activity.owner_table='event' AND (event.is_public=1 OR EXISTS(SELECT event_id FROM invitee WHERE event_id=event.id AND invitee.employee_id={$employeeId})) AND event.disabled=0"
            .  "     LEFT JOIN employee AS employee_owner "
            .  "         ON activity.owner_id = employee_owner.id AND activity.owner_table='employee' AND employee_owner.disabled=0"
            .  "     LEFT JOIN project_post "
            .  "         ON activity.owner_id = project_post.id AND activity.owner_table='project_post' AND project_post.disabled=0 AND (EXISTS(SELECT * FROM project WHERE project.id=project_post.project_id and project.is_public=1 AND project.disabled=0) OR EXISTS(SELECT * FROM project_employee WHERE project_employee.project_id=project_id AND project_employee.employee_id={$employeeId} AND project_employee.disabled=0)) "
            .  "     LEFT JOIN project AS p_project "
            .  "         ON project_post.project_id=p_project.id AND p_project.disabled=0 "
            .  " WHERE activity.company_id={$companyId} AND activity.disabled=0 "
            .  " ORDER BY activity.datetime_created DESC "
            .  " LIMIT " . ($offset - 1) * $perPage  .", " . $offset * $perPage ;
        
            return [
                'activities' => \Yii::$app->getDb()->createCommand($sql)->queryAll(),
                'totalRow' => \Yii::$app->getDb()->createCommand('SELECT FOUND_ROWS() AS total_row')->queryAll(),
            ];
    }
}
