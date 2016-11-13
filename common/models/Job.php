<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Job extends \backend\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
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
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Name'),
            'description' => Yii::t('backend', 'Description'),
            'datetime_created' => Yii::t('backend', 'Datetime Created'),
            'lastup_datetime' => Yii::t('backend', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('backend', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('backend', 'Lastup Employee ID'),
            'disabled' => Yii::t('backend', 'Disabled'),
        ];
    }
}
