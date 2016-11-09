<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_group_allocation".
 *
 * @property string $id
 * @property string $company_id
 * @property string $task_group_id
 * @property string $task_id
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property string $disabled
 */
class TaskGroupAllocation extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_group_allocation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'task_group_id', 'task_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id', 'disabled'], 'integer']
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
            'task_group_id' => 'Task Group ID',
            'task_id' => 'Task ID',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }   

    /**
     * Add Task group
     *
     * @param array $dataInsert
     * @return boolean
     */
    public function getTaskgroups() {
        return $this->hasOne(TaskGroup::className(), ['id' => 'task_group_id']);
    }
    
    /**
     * Add Task group batchInsert
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
