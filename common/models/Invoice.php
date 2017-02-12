<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property string $id
 * @property string $company_id
 * @property string $invoice_number
 * @property string $order_id
 * @property string $employee_id
 * @property string $staff_id
 * @property string $status_id
 * @property string $payment_method_id
 * @property string $campaign_id
 * @property string $total_money
 * @property string $expired_datetime
 * @property string $note
 * @property string $address
 * @property string $tax
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Invoice extends \common\components\db\ActiveRecord
{
    const COLUNM_NAME_WAIT_PAY = 'invoice.wait_pay';
    const COLUNM_NAME_PAYED = 'invoice.payed';
    const COLUNM_NAME_PENDING = 'invoice.pending';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'invoice_number', 'order_id', 'employee_id', 'staff_id', 'status_id', 'payment_method_id', 'campaign_id', 'total_money', 'expired_datetime', 'tax', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['order_id', 'employee_id', 'status_id', 'total_money', 'note', 'address'], 'required'],
            [['note'], 'string'],
            [['disabled'], 'boolean'],
            [['address'], 'string', 'max' => 255]
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
            'invoice_number' => Yii::t('member', 'Invoice Number'),
            'order_id' => Yii::t('member', 'Order ID'),
            'employee_id' => Yii::t('member', 'Employee ID'),
            'staff_id' => Yii::t('member', 'Staff ID'),
            'status_id' => Yii::t('member', 'Status ID'),
            'payment_method_id' => Yii::t('member', 'Payment Method ID'),
            'campaign_id' => Yii::t('member', 'Campaign ID'),
            'total_money' => Yii::t('member', 'Total Money'),
            'expired_datetime' => Yii::t('member', 'Expired Datetime'),
            'note' => Yii::t('member', 'Note'),
            'address' => Yii::t('member', 'Address'),
            'tax' => Yii::t('member', 'Tax'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
    
    public static function getMostRecentInvoiceByCompanyId() {
               return self::find()
                        ->select('*')
                        ->orderBy('datetime_created DESC')
                        ->asArray()
                        ->one();
    }
}
