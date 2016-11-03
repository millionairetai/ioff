<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan_type".
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
class PlanType extends \backend\components\db\ActiveRecord
{
    ////////////////////////////////////
    //Maybe change afterward
    ////////////////////////////////////
    const FREE = 'Free';
    const STANDARD = 'Standard';
    const PREMIUM = 'Premium';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plan_type';
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
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'datetime_created' => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' => Yii::t('common', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('common', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' => Yii::t('common', 'Disabled'),
        ];
    }
    
    /**
     * Get plan type by name
     * 
     * @param string $name
     * @return id
     */
    public static function getByName($name) {
        return self::find()
                    ->select(['id', 'name',])
                    ->where(['name' => $name])
                    ->asArray()
                    ->one();
    }    
    
}
