<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_assignment".
 *
 * @property string $id
 * @property string $company_id
 * @property string $task_id
 * @property string $employee_id
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class TaskAssignment extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'task_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['task_id', 'employee_id'], 'required'],
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
            'task_id' => 'Task ID',
            'employee_id' => 'Employee ID',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    /**
     * Add invitation batchInsert
     *
     * @param array $dataInsert
     * @return boolean
     */
    public static function batchInsert($dataInsert) {
        if (!empty($dataInsert)) {
            if (!\Yii::$app->db->createCommand()->batchInsert(self::tableName(), array_keys($dataInsert[0]), $dataInsert)->execute()) {
                throw new \Exception('Save record to table invitation fail');
            }
        }
    
        return true;
    }
}
