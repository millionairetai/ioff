<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "authority_assigment".
 *
 * @property string $id
 * @property string $company_id
 * @property integer $authority_id
 * @property integer $action_id
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class AuthorityAssigment extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authority_assigment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'authority_id', 'action_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['authority_id', 'action_id'], 'required'],
            [['disabled'], 'boolean']
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
            'authority_id' => 'Authority ID',
            'action_id' => 'Action ID',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
}
