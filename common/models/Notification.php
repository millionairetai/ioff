<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property string $id
 * @property string $owner_id
 * @property string $company_id
 * @property string $owner_table
 * @property string $employee_id
 * @property string $owner_employee_id
 * @property string $type
 * @property string $content
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Notification extends \common\components\db\ActiveRecord {

    const TABLE_PROJECT = "project";
    const TABLE_EVENT = "event";
    const TABLE_TASK = "task";

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['owner_id', 'owner_table', 'employee_id', 'type'], 'required'],
            [['company_id', 'owner_id', 'employee_id', 'owner_employee_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['content'], 'string'],
            [['disabled'], 'boolean'],
            [['owner_table'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 99]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'owner_id' => 'Owner ID',
            'owner_table' => 'Owner Table',
            'employee_id' => 'Employee ID',
            'owner_employee_id' => 'Owner Employee ID',
            'type' => 'Type',
            'content' => 'Content',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }

    /**
     * Make content for notfication
     * 
     * @param string $type
     * @param string $info
     * @return string
     */
    public static function makeContent($type, $info) {
        return \Yii::$app->user->identity->firstname . " " . $type . " " . $info;
    }

    /**
     * Get notification by employee id.
     * 
     * @param integer $employeeId
     * @param integer $offset
     * @param integer $perPage
     * 
     * @return array
     */
    public static function getByEmployeeId($employeeId, $offset, $perPage = 10) {
        $companyId = Yii::$app->user->identity->company_id;
        $sql = " SELECT SQL_CALC_FOUND_ROWS notification.id, notification.owner_table, notification.datetime_created, notification.type, employee.firstname, employee.lastname, employee.profile_image_path, " 
            .  "     project.name as project_name,task.name as task_name, event.name as event_name, "
            .  "     task_p.name as task_p_name, event_p.name as event_p_name, project_p.name as project_p_name, "
            .  "     project.id as project_id, task.id as task_id, event.id as event_id, project_p.id as project_p_id, "    
            .  "     task_p.id as task_p_id, event_p.id as event_p_id, "    
            .  "     requestment.id as requestment_id"
            .  " FROM notification "
            .  "     LEFT JOIN employee "
            .  "         ON employee.id=notification.owner_employee_id AND employee.disabled = 0 "
            .  "     LEFT JOIN project "
            .  "         ON project.id = notification.owner_id AND notification.owner_table='project' AND project.disabled = 0"
            .  "     LEFT JOIN task "
            .  "         ON task.id = notification.owner_id AND notification.owner_table='task' AND task.disabled = 0"
            .  "     LEFT JOIN event "
            .  "         ON event.id = notification.owner_id AND notification.owner_table='event' AND event.disabled = 0"
            .  "     LEFT JOIN task  as task_p "
            .  "         ON task_p.id = notification.owner_id AND notification.owner_table='task_post' AND task_p.disabled = 0"
            .  "  LEFT JOIN event as event_p "
            .  "         ON event_p.id = notification.owner_id AND notification.owner_table='event_post' AND event_p.disabled = 0"
            .  "  LEFT JOIN project as project_p "
            .  "         ON project_p.id = notification.owner_id AND notification.owner_table='project_post' AND project_p.disabled = 0"
            .  "  LEFT JOIN requestment "
            .  "         ON requestment.id = notification.owner_id AND notification.owner_table='requestment' AND requestment.disabled = 0"
            .  " WHERE notification.employee_id={$employeeId} AND notification.company_id={$companyId} AND notification.disabled=0 "
            .  " ORDER BY notification.datetime_created DESC "
            .  " LIMIT " . ($offset - 1) * $perPage  .", " . $offset * $perPage ;
            
            return [
                'notification' => \Yii::$app->getDb()->createCommand($sql)->queryAll(),
                'totalRow' => \Yii::$app->getDb()->createCommand('SELECT FOUND_ROWS() AS total_row')->queryAll(),
            ];
    }

}
