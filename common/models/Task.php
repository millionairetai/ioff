<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;


/**
 * This is the model class for table "task".
 *
 * @property string $id
 * @property string $company_id
 * @property string $project_id
 * @property string $priority_id
 * @property string $status_id
 * @property string $kpi_id
 * @property string $parent_id
 * @property string $employee_id
 * @property string $name
 * @property string $description
 * @property string $description_parse
 * @property string $start_datetime
 * @property string $duedatetime
 * @property string $estimate_hour
 * @property string $worked_hour
 * @property integer $completed_percent
 * @property boolean $is_public
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Task extends \common\components\db\ActiveRecord {

//    public $sms = 0;
    
    function __construct($config = []) {
        parent::__construct();
        $companyId = \Yii::$app->user->getCompanyId();
        $this->setCompanyId($companyId);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_id', 'project_id', 'priority_id', 'status_id', 'kpi_id', 'parent_id', 'employee_id', 'start_datetime', 'duedatetime', 'estimate_hour', 'worked_hour', 'completed_percent', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['name', 'description'], 'required'],
            [['description', 'description_parse'], 'string'],
            [['is_public', 'disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'project_id' => 'Project ID',
            'priority_id' => 'Priority ID',
            'status_id' => 'Status ID',
            'kpi_id' => 'Kpi ID',
            'parent_id' => 'Parent ID',
            'employee_id' => 'Employee ID',
            'name' => 'Name',
            'description' => 'Description',
            'description_parse' => 'Description Parse',
            'start_datetime' => 'Start Datetime',
            'duedatetime' => 'Duedatetime',
            'estimate_hour' => 'Estimate Hour',
            'worked_hour' => 'Worked Hour',
            'completed_percent' => 'Completed Percent',
            'is_public' => 'Is Public',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    public static function find()
    {  
        //use origin class to avoid totalCount = 0
        return new \yii\db\ActiveQuery(get_called_class());
    }
    
    public function setCompanyId($companyId){
        if($companyId){            
            $this->company_id = $companyId;
        }
        
        return $this->company_id;
    }
                                
    public function getStatus(){
        return $this->hasOne(Status::className(),['id'=>'status_id']);
    }
    
    public function getCreator(){
        return $this->hasOne(Employee::className(), ['id'=>'created_employee_id']);
    }
    
    public function getFollowers(){
       return $this->hasMany(Employee::className(), ['id'=>'employee_id'])->viaTable('follower', ['task_id' => 'id']);         
    }
    
    public function getAssignees(){
       return $this->hasMany(Employee::className(), ['id'=>'employee_id'])->viaTable('task_assignment', ['task_id' => 'id']);         
    }
        
    public function getCompany(){
        return $this->hasOne(Company::className(), ['id'=>'company_id']);        
    }
    
    public function getTaskGroups(){
        return $this->hasMany(TaskGroup::className(), ['project_id'=>'id']);
    }
            
}
