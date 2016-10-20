<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_employee".
 *
 * @property string $id
 * @property string $company_id
 * @property string $project_id
 * @property string $employee_id
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class ProjectEmployee extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'project_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['project_id', 'employee_id'], 'required'],
            [['disabled'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'company_id' => Yii::t('common', 'Company ID'),
            'project_id' => Yii::t('common', 'Project ID'),
            'employee_id' => Yii::t('common', 'Employee ID'),
            'datetime_created' => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' => Yii::t('common', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('common', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' => Yii::t('common', 'Disabled'),
        ];
    }
    
    /**
     * Get employees by project id
     * 
     * @param int $projectId 
     * @return boolean|array
     */
    public static function getEmployeesByProjectId($projectId) {        
        return Employee::find()->select(['id', 'firstname', 'lastname', 'email', 'profile_image_path'])
                ->andWhere(['id' => self::find()->select(['employee_id'])
                    ->andWhere(['project_id' => $projectId])
                    ->andCompanyId()
                ])
                ->andCompanyId()
                ->all();
    }
}
