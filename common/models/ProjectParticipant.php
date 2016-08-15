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
    
    /**
     * get list ProjectParticipant by $projectId
     * @param string $projectId
     * @return boolean|array
     */
    public static function getListByProjectId($projectId = null){
        if ($projectId == null) {
            return false;
        }
        $projectParticipants = ProjectParticipant::findAll(['company_id' => \Yii::$app->user->getCompanyId(), 'project_id' => $projectId]);
        if (!empty($projectParticipants)) {
            $result = [];
            foreach ($projectParticipants as $projectParticipant) {
                $result['owner_table'][$projectParticipant->owner_table][] = $projectParticipant->owner_id;
                if ($projectParticipant->owner_table == 'department') {
                    $result['department'][$projectParticipant->department->id] = $projectParticipant->department->name;
                }
            }
            return $result;
        }
        return false;
    }
}