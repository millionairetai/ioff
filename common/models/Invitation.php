<?php

namespace common\models;

use common\components\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "invitation".
 *
 * @property string $id
 * @property string $company_id
 * @property string $event_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Invitation extends ActiveRecord
{
    const TABLE_EMPLOYEE = "employee";
    const TABLE_DEPARTMENT = "department";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invitation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'owner_id'], 'required'],
            [['company_id', 'event_id', 'owner_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['owner_table'], 'string', 'max' => 99]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('common', 'ID'),
            'company_id' 				 => Yii::t('common', 'Company id'),
            'event_id' 			 => Yii::t('common', 'Event ID'),
            'owner_id' 			 => Yii::t('common', 'Owner ID'),
            'owner_table' 		 => Yii::t('common', 'Owner Table'),
            'datetime_created'   => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('common', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' 			 => Yii::t('common', 'Disabled'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'owner_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee() {
        return $this->hasOne(Employee::className(), ['id' => 'owner_id']);
    }
    
    /**
     * get list ProjectParticipant by $projectId
     * @param string $projectId
     * @return boolean|array
     */
    public static function getListByEventId($eventId = null){
        if ($eventId == null)  return false;
        
        $invitatinons = Invitation::findAll(['company_id' => \Yii::$app->user->getCompanyId(), 'event_id' => $eventId]);
        if (!empty($invitatinons)) {
            $result = [];
            foreach ($invitatinons as $invitatinon) {
                if ($invitatinon->owner_table == Department::tableName()) {
                    $result[$invitatinon->owner_table][$invitatinon->owner_id] = $invitatinon->department->name;
                }
                if ($invitatinon->owner_table == Employee::tableName()) {
                    $result[$invitatinon->owner_table][$invitatinon->owner_id] = $invitatinon->employee->fullname;
                }
            }
            $departments = isset($result['department']) ? array_keys($result['department']) : null;
            $employees   = isset($result['employee'])   ? array_keys($result['employee']) : null;
            $result['departmentAndEmployee'] = Employee::getlistByepartmentIdsAndEmployeeIds($departments, $employees);
            return $result;
        }
        return false;
    }
}
