<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_participant".
 *
 * @property string $id
 * @property string $project_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class ProjectParticipant extends \common\components\db\ActiveRecord
{
    const TABLE_EMPLOYEE = "employee";
    const TABLE_DEPARTMENT = "department";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_participant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'owner_id', 'owner_table'], 'required'],
            [['project_id', 'owner_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['owner_table'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'owner_id' => 'Owner ID',
            'owner_table' => 'Owner Table',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
}