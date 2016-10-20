<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_participant".
 *
 * @property string $id
 * @property string $company_id
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
            [['company_id', 'project_id', 'owner_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
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
            'company_id' => 'Company ID',
            'project_id' => 'Project ID',
            'owner_id' => 'Owner ID',
            'owner_table' => 'Owner Table',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment() {
    	return $this->hasOne(Department::className(), ['id' => 'owner_id']);
    }
    
//    public function getEmployeesByProjectId($projectId){//
//        $departmentProjectParticipants = self::find()->joinWith('company')->select('owner_id')->where(['owner_table'=>self::TABLE_DEPARTMENT,'project_id'=>$projectId])->all();
//        $employeeProjectParticipants = self::find()->joinWith('company')->select('owner_id')->where(['owner_table'=>self::TABLE_EMPLOYEE,'project_id'=>$projectId])->all();
//        
//        $departmentIds = [];
//        $employeeIds = [];
//        
//        foreach($departmentProjectParticipants as $projectParticipantDepartment) {
//            $departmentIds[] = $projectParticipantDepartment->owner_id;
//        }
//        
//        foreach($employeeProjectParticipants as $projectParticipantEmployee) {
//            $employeeIds[] = $projectParticipantEmployee->owner_id;
//        }
//        
//        $departmentEmployees = Employee::find()->joinWith('company')->where(['department_id'=>$departmentIds])->all();
//        $optionalEmployees = [];
//        
//        if(!empty($departmentIds)){
//            $optionalEmployees = Employee::find()->joinWith('company')->where([Employee::tableName().'.id'=>$employeeIds])->andWhere("department_id not in (".implode(",", $departmentIds).")")->all();
//        }else{
//            $optionalEmployees = Employee::find()->joinWith('company')->where([Employee::tableName().'.id'=>$employeeIds])->all();
//        }
//        
//                
//        return array_merge($departmentEmployees,$optionalEmployees);
//    }
    
    public function getCompany(){
        return $this->hasOne(Company::className(), ['id'=>'company_id']);        
    }
}