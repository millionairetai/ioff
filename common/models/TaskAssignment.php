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
class TaskAssignment extends \common\components\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'task_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_id', 'task_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['task_id', 'employee_id'], 'required'],
            [['disabled'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
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
     * Get worked hour employee by task id.
     * @param interger $taskId
     * @return array
     */
    public static function getWorkedHourEmployeeByTaskId($taskId) {
        $employees = Employee::find()
                ->select(['task_assignment.worked_hour', 'employee.firstname', 'employee.lastname', 'employee.id', 'employee.profile_image_path',
                    'employee.company_id', 'employee.id'])
                ->leftJoin('task_assignment', 'task_assignment.employee_id=employee.id')
                ->where(['task_assignment.task_id' => $taskId]);

        return $employees
                        ->andCompanyId(false, 'employee')
                        ->asArray()
                        ->all();
    }

}
