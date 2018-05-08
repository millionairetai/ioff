<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activity_post_participant".
 *
 * @property string $id
 * @property string $company_id
 * @property string $activity_post_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class ActivityPostParticipant extends \common\components\db\ActiveRecord
{
    //Table for owner_table column.
    const TABLE_DEPARTMENT = 'department';
    const TABLE_EMPLOYEE = 'employee';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_post_participant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'activity_post_id', 'owner_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['activity_post_id', 'owner_id', 'owner_table', 'created_employee_id'], 'required'],
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
            'id' => Yii::t('member', 'ID'),
            'company_id' => Yii::t('member', 'Company ID'),
            'activity_post_id' => Yii::t('member', 'Activity Post ID'),
            'owner_id' => Yii::t('member', 'Owner ID'),
            'owner_table' => Yii::t('member', 'Owner Table'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
}
