<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee_space".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $employee_id
 * @property string $space_project
 * @property string $space_task
 * @property string $space_calendar
 * @property string $space_annoucement
 * @property string $space_statergy_map
 * @property string $space_kpi
 * @property string $space_employee
 * @property string $space_contract
 * @property string $space_subject
 * @property string $space_post
 * @property string $space_total
 * @property integer $datetime_created
 * @property integer $lastup_datetime
 * @property integer $lastup_employee_id
 * @property boolean $disabled
 */
class EmployeeSpace extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_space';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id'], 'required'],
            [['company_id','employee_id', 'space_project', 'space_task', 'space_calendar', 'space_annoucement', 'space_statergy_map', 'space_kpi', 'space_employee', 'space_contract', 'space_subject', 'space_post', 'space_total', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
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
            'space_project' => 'Space  Project',
            'space_task' => 'Space Task',
            'space_calendar' => 'Space Calendar',
            'space_annoucement' => 'Space Annoucement',
            'space_statergy_map' => 'Space Statergy Map',
            'space_kpi' => 'Space Kpi',
            'space_employee' => 'Space Employee',
            'space_contract' => 'Space Contract',
            'space_subject' => 'Space Subject',
            'space_post' => 'Space Post',
            'space_total' => 'Space Total',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
}
