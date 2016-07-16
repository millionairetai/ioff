<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $description
 * @property string $column_name
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Status extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'column_name'], 'required'],
            [['description'], 'string'],
            [['company_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['column_name'], 'string', 'max' => 99]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company id',
            'name' => 'Name',
            'description' => 'Description',
            'column_name' => 'Column Name',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    public static function getStatusName($id){
    	return Status::findOne($id);
    }
}
