<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_detail".
 *
 * @property string $id
 * @property string $company_id
 * @property string $invoice_id
 * @property integer $period_time_id
 * @property integer $plan_type_id
 * @property string $max_user_register
 * @property string $max_storage_register
 * @property string $discount
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class InvoiceDetail extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'invoice_id', 'period_time_id', 'plan_type_id', 'max_user_register', 'max_storage_register', 'discount', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['invoice_id', 'period_time_id', 'plan_type_id'], 'required'],
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
            'invoice_id' => Yii::t('member', 'Invoice ID'),
            'period_time_id' => Yii::t('member', 'Period Time ID'),
            'plan_type_id' => Yii::t('member', 'Plan Type ID'),
            'max_user_register' => Yii::t('member', 'Max User Register'),
            'max_storage_register' => Yii::t('member', 'Max Storage Register'),
            'discount' => Yii::t('member', 'Discount'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
}