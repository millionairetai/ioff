<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "follower".
 *
 * @property string $id
 * @property string $company_id
 * @property string $employee_id
 * @property string $task_id
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Follower extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'follower';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'employee_id', 'task_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['employee_id', 'task_id'], 'required'],
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
            'task_id' => 'Task ID',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    public function getFollowersByTaskIds($taskIds){
        $employees =  Employee::find()
            ->select([
                self::tableName().'.task_id as task_id',
                Employee::tableName().'.firstname as firstname',
                Employee::tableName().'.email as email',
                Employee::tableName().'.profile_image_path as profile_image_path',
            ])    
            ->join('inner join',self::tableName(), self::tableName().'.employee_id'. '=' . Employee::tableName().'.id')
                
            ->where(['task_id'=>$taskIds])
            ->andCompanyId()
            ->all();
        
        $results = [];
        
        foreach($employees as $employee){
            $results[$employee->task_id][] = ['firstname'=>$employee->firstname,'email'=>$employee->email,'image'=>$employee->getImage()];
        }
        
        return $results;
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
