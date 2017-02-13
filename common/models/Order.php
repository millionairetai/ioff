<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property string $company_id
 * @property string $order_number
 * @property string $employee_id
 * @property string $status_id
 * @property string $expired_datetime
 * @property string $duedate
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Order extends \common\components\db\ActiveRecord
{
    const COLUNM_NAME_WAIT_PAY = 'order.wait_pay';
    const COLUNM_NAME_PAYED = 'order.wait_pay';
    const COLUNM_NAME_PENDING = 'order.pending';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'order_number', 'employee_id', 'status_id', 'expired_datetime', 'duedate', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['employee_id', 'status_id', 'lastup_employee_id'], 'required'],
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
            'order_number' => Yii::t('member', 'Order Number'),
            'employee_id' => Yii::t('member', 'Employee ID'),
            'status_id' => Yii::t('member', 'Status ID'),
            'expired_datetime' => Yii::t('member', 'Expired Datetime'),
            'duedate' => Yii::t('member', 'Duedate'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
    
    public static function isExistedWaitingPaymentOrder($companyId) {
        $invoices = self::find()
                        ->select(['order.id'])
                        ->leftJoin('status', 'order.status_id = status.id')
                        ->where(['order.company_id' => $companyId, 'status.column_name' => self::COLUNM_NAME_WAIT_PAY])
                        ->asArray()
                        ->one();
        
        if (!empty($invoices)) {
            return true;
        }
        
        return false;
    }
}
