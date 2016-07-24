<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_post".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $employee_id
 * @property integer $project_id
 * @property integer $parent_employee_id
 * @property integer $parent_id
 * @property string $content
 * @property string $content_parse
 * @property boolean $is_log_history
 * @property integer $datetime_created
 * @property integer $lastup_datetime
 * @property integer $created_employee_id
 * @property integer $lastup_employee_id
 * @property boolean $disabled
 */
class ProjectPost extends \common\components\db\ActiveRecord
{
	const TABLE_PROJECTPOST = "project_post";
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'employee_id', 'parent_employee_id', 'parent_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['content', 'content_parse'], 'required'],
            [['content', 'content_parse'], 'string'],
            [['disabled', 'is_log_history'], 'boolean'],
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee() {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'project_id' => 'Project id',
            'employee_id' => 'Employee ID',
            'parent_employee_id' => 'Parent Employee ID',
            'parent_id' => 'Parent ID',
            'content' => 'Content',
            'content_parse' => 'Content Parse',
            'is_log_history' => 'Is Log History',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    /**
     * Get list project post by project id
     * 
     * @param integer $projectId
     * @param integer $currentPage
     * @param integer $itemPerPage
     * @return array|boolean
     */
    public static function getProjectPosts($projectId, $currentPage = 1, $itemPerPage = 10) {
        $offset = $currentPage * $itemPerPage;
        
        if (isset($projectId)){
            $data =  ProjectPost::find()
                        ->where(['project_id' => $projectId])
                        ->orderBy('datetime_created DESC')
                        ->limit($offset)
                        ->andCompanyId()
                        ->all();
            
            return $data;
        }
        
        return [];
    }
}
