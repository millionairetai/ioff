<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property string $id
 * @property string $manager_project_id
 * @property integer $priority_id
 * @property integer $status_id
 * @property string $parent_id
 * @property string $name
 * @property string $description
 * @property string $description_parse
 * @property string $start_datetime
 * @property string $duedatetime
 * @property integer $completed_percent
 * @property integer $estimate_hour
 * @property integer $worked_hour
 * @property boolean $is_public
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Project extends \common\components\db\ActiveRecord {

    public $sms = 0;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [[ 'priority_id', 'status_id', 'parent_id', 'name', 'description', 'description_parse'], 'required','message' => Yii::t('member', 'validate_required')],
            [['manager_project_id', 'priority_id', 'status_id', 'parent_id', 'completed_percent', 'estimate_hour', 'worked_hour', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer','message' => Yii::t('member', 'validate_integer')],
            [['description', 'description_parse'], 'string','message' => Yii::t('member', 'validate_string')],
            [['is_public', 'disabled'], 'boolean','message' => Yii::t('member', 'validate_boolean')],
            [['name'], 'string', 'max' => 255,'tooLong' => Yii::t('member', 'validate_max_length')],
            [['start_datetime', 'duedatetime','sms'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'manager_project_id' => Yii::t('member', 'project_manager'),
            'priority_id' => Yii::t('member', 'project_priority'),
            'status_id' => Yii::t('member', 'project_status'),
            'parent_id' => Yii::t('member', 'project_parent'),
            'name' => Yii::t('member', 'project_name'),
            'description' => Yii::t('member', 'project_description'),
            'description_parse' => Yii::t('member', 'project_description_parse'),
            'start_datetime' => Yii::t('member', 'project_start'),
            'duedatetime' => Yii::t('member', 'project_end'),
            'completed_percent' => Yii::t('member', 'project_completed_percent'),
            'estimate_hour' => Yii::t('member', 'project_estimate'),
            'worked_hour' => Yii::t('member', 'project_work'),
            'is_public' => Yii::t('member', 'project_public'),
            'datetime_created' => Yii::t('member', 'created_date'),
            'lastup_datetime' => Yii::t('member', 'last_date'),
            'lastup_employee_id' => Yii::t('member', 'employee_id'),
            'disabled' => Yii::t('member', 'disabled'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }
    
    /**
     * get project based on employee
     */
    public static function getProject($params,$currentPage = 1,$itemPerPage = 10){
        $sql = "SELECT project.id,project.name,project.description,project.status_id,project.completed_percent,project.worked_hour,project.estimate_hour,status.name as status_name FROM project  INNER JOIN status ON project.status_id =   status.id         
        WHERE (project.is_public=1 OR project.manager_project_id=:empolyee_id OR project.lastup_employee_id=:empolyee_id OR              
        EXISTS(SELECT *              
         FROM project_participant             
         WHERE project_participant.project_id  = project.id AND project_participant.owner_table='employee' AND project_participant.owner_id=:empolyee_id AND project_participant.disabled=0               
        ) OR              
        EXISTS(SELECT *              
         FROM project_participant             
          INNER JOIN department ON department.id=project_participant.owner_id AND project_participant.owner_table='department' AND department.disabled=0             
          INNER JOIN employee ON department.id=employee.department_id AND employee.id=:empolyee_id AND employee.disabled=0            
         WHERE project_participant.project_id  = project.id AND project_participant.disabled=0         
        )) AND project.disabled=0
        ORDER BY project.datetime_created DESC";
        
        $offset = $currentPage  * $itemPerPage;
        $sql_limit = $sql;
        $sql_limit .= " limit 0 ," . $offset;
        $command = \Yii::$app->getDb()->createCommand($sql_limit)->bindValues($params);
        $data = $command->queryAll();
        
        return ['data' => $data,'sql' => $sql];
    }

    

}
