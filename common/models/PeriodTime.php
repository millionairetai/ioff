<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "period_time".
 *
 * @property integer $id
 * @property string $name
 * @property integer $month_value
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class PeriodTime extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'period_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['month_value', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['description'], 'string'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('member', 'ID'),
            'name' => Yii::t('member', 'Name'),
            'month_value' => Yii::t('member', 'Month Value'),
            'description' => Yii::t('member', 'Description'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
}
