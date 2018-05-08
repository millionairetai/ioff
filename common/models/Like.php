<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "like".
 *
 * @property string $id
 * @property string $company_id
 * @property string $employee_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property integer $disabled
 */
class Like extends \common\components\db\ActiveRecord
{
     const TABLE_COMMENT = "comment";  
     const TABLE_ACTIVITY = "activity";  
     
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'employee_id', 'owner_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id', 'disabled'], 'integer'],
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
            'employee_id' => Yii::t('member', 'Employee ID'),
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
