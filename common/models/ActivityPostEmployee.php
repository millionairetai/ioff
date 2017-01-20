<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activity_post_employee".
 *
 * @property string $id
 * @property string $company_id
 * @property string $activity_post_id
 * @property string $employee_id
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class ActivityPostEmployee extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_post_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'activity_post_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['employee_id'], 'required'],
            [['disabled'], 'boolean']
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
            'employee_id' => Yii::t('member', 'Employee ID'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
}
