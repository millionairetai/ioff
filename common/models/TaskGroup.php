<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_group".
 *
 * @property string $id
 * @property string $company_id
 * @property string $project_id
 * @property string $name
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class TaskGroup extends \common\components\db\ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'project_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'description' => 'Description',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }  
    
    /**
     * Get all of follow tasks that employee follow.
     * @param interger $itemPerPage
     * @param interger $currentPage
     * @param string $searchText
     * @return array|null
     */
    public static function getTaskGroups($projectId) {
       return self::find()->select(['id', 'name'])->where(['project_id' => $projectId])->andCompanyId()->asArray()->all();
    }
}
