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
    const TABLE_PROJECT = "project";  
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
}
