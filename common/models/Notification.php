<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property string $id
 * @property string $owner_id
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
class Notification extends \common\components\db\ActiveRecord
{
    const TABLE_PROJECT = "project";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'owner_table', 'employee_id', 'type'], 'required'],
            [['owner_id', 'employee_id', 'owner_employee_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
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
}