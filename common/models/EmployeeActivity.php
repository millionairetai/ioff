<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee_activity".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $employee_id
 * @property string $activity_project
 * @property string $activity_task
 * @property string $activity_calendar
 * @property string $activity_annoucement
 * @property string $activity_statergy_map
 * @property string $activity_kpi
 * @property string $activity_employee
 * @property string $activity_contract
 * @property string $activity_subject
 * @property string $activity_post
 * @property string $activity_total
 * @property integer $datetime_created
 * @property integer $lastup_datetime
 * @property integer $lastup_employee_id
 * @property boolean $disabled
 */
class EmployeeActivity extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id'], 'required'],
            [['company_id', 'employee_id', 'activity_project', 'activity_task', 'activity_calendar', 'activity_annoucement', 'activity_statergy_map', 'activity_kpi', 'activity_employee', 'activity_contract', 'activity_subject', 'activity_post', 'activity_total', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean']
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
            'employee_id' => 'Employee ID',
            'activity_project' => 'Activity Project',
            'activity_task' => 'Activity Task',
            'activity_calendar' => 'Activity Calendar',
            'activity_annoucement' => 'Activity Annoucement',
            'activity_statergy_map' => 'Activity Statergy Map',
            'activity_kpi' => 'Activity Kpi',
            'activity_employee' => 'Activity Employee',
            'activity_contract' => 'Activity Contract',
            'activity_subject' => 'Activity Subject',
            'activity_post' => 'Activity Post',
            'activity_total' => 'Activity Total',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
}
