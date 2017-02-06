<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $column_name
 * @property string $description
 * @property integer $max_user
 * @property string $max_storage
 * @property string $fee_user
 * @property string $fee_storage
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class PlanType extends \common\components\db\ActiveRecord
{
    ////////////////////////////////////
    //Maybe change afterward
    ////////////////////////////////////
    const COLUMN_NAME_FREE = 'free';
    const COLUMN_NAME_STANDARD = 'standard';
    const COLUMN_NAME_PREMIUM = 'premium';
    
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
            [['name', 'column_name', 'max_storage'], 'required'],
            [['description'], 'string'],
            [['max_user', 'max_storage', 'fee_user', 'fee_storage', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['column_name'], 'string', 'max' => 50]
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
            'column_name' => Yii::t('member', 'Column Name'),
            'description' => Yii::t('member', 'Description'),
            'max_user' => Yii::t('member', 'Max User'),
            'max_storage' => Yii::t('member', 'Max Storage'),
            'fee_user' => Yii::t('member', 'Fee User'),
            'fee_storage' => Yii::t('member', 'Fee Storage'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
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
    
    /**
     * Get plan type by column name
     * 
     * @param string $columnName
     * @return array
     */
    public static function getByColumnName($columnName) {
        return self::find()
                    ->select(['id', 'name',])
                    ->where(['column_name' => $columnName])
                    ->asArray()
                    ->one();
    }
    
    /**
     * Get plan type index by column name
     * @return array
     */
    public static function getsIndexByColumnName() {
        return self::find()->select(['id', 'name', 'column_name', 'max_user', 'max_storage', 'fee_user', 'fee_storage'])
                ->indexBy('column_name')
                ->asArray()
                ->all();
    }
}
