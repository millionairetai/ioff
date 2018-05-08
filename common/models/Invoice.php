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
    
    /**
     * Get most recent invoice by company idk
     * @param array $ids
     * @return array
     */
    public static function getMostRecentInvoiceByCompanyId($companyId) {
               return self::find()
                        ->select('*')
                        ->orderBy('datetime_created DESC')
                        ->where(['company_id' => $companyId])
                        ->asArray()
                        ->one();
    }

    /**
     * Get revenue in month
     * @return array
     */
    public static function getRevenueInMonth() {
        $totalMoney = self::find()
                ->select('SUM(total_money) AS total_revenue_in_month')
                ->where('MONTH(from_unixtime(invoice.datetime_created)) = MONTH(CURRENT_DATE())')
                ->asArray()
                ->one();  

        return !empty($totalMoney['total_revenue_in_month']) ? $totalMoney['total_revenue_in_month'] : 0;
    }
    
    /**
     * Get previous month revenue.
     * @return array
     */    
    public static function getPreviousMonthRevenue() {
        $totalMoney = self::find()
                ->select('SUM(total_money) AS total_revenue_previous_month')
                ->where('MONTH(from_unixtime(invoice.datetime_created)) = (MONTH(CURRENT_DATE()) - 1)')
                ->asArray()
                ->one();  
        
        return !empty($totalMoney['total_revenue_previous_month']) ? $totalMoney['total_revenue_previous_month'] : 0;
    }
    
    /**
     * Get revenue per month
     * @return array
     */
    public static function getRevenuePerMonth() {
        return self::find()
                ->select('SUM(total_money) AS `total_money`, MONTH(FROM_UNIXTIME(invoice.datetime_created)) AS `month`')
                ->groupBy('MONTH(FROM_UNIXTIME(invoice.datetime_created))')
                ->orderBy('invoice.datetime_created DESC')
                ->asArray()
                ->all();  
    }

    /**
     * Get revenue per employee
     * @return array
     */    
    public static function getRevenuePerEmployee() {
        return self::find()
                ->select('SUM(total_money) AS `total_money`, staff.name AS `staff_name`')
                ->leftJoin('staff', 'invoice.staff_id=staff.id')
                ->groupBy('staff.id')
                ->where('invoice.staff_id <> 0')
                ->orderBy('invoice.datetime_created DESC')
                ->asArray()
                ->all();  
    }
    
    /**
     * Get total revenue each plan type
     * @return array
     */    
    public static function getTotalRevenueEachPlanType() {
        return self::find()
                ->select('SUM(total_money) AS `total_money`, plan_type.name AS `plan_type_name`, plan_type.column_name AS `plan_type_column_name`')
                ->leftJoin('company', 'company.id=invoice.company_id')
                ->leftJoin('plan_type', 'plan_type.id=company.plan_type_id')
                ->where('plan_type.name <> "' . PlanType::COLUMN_NAME_FREE .  '"')
                ->groupBy('company.plan_type_id')
                ->indexBy('plan_type_column_name')
                ->asArray()
                ->all();  
    }
    
    /**
     * Gets invoice history
     * 
     * @param integer $companyId
     * @return array
     */
    public static function getsByCompanyId($companyId) {
          return self::find()
                ->select(['invoice.id', 'invoice.invoice_number', 'invoice.employee_id', 'invoice.company_id', 'invoice.expired_datetime', 'invoice.datetime_created',
                            'invoice_detail.number_month', 'invoice_detail.max_user_register', 'invoice_detail.max_storage_register', 'invoice_detail.plan_type_id', 
                            'status.name AS status_name','status.column_name AS status_column_name', 'plan_type.name AS plan_type_name', 'plan_type.column_name AS plan_type_column_name',
                            'employee.firstname AS employee_firstname', 'employee.lastname AS employee_lastname', 'employee.mobile_phone AS employee_mobile_phone',
                            'employee.street_address_1 AS employee_street_address_1', 'employee.street_address_2 AS employee_street_address_2', 'employee.email AS employee_email',])
                        ->leftJoin('invoice_detail', 'invoice.id=invoice_detail.invoice_id')
                        ->leftJoin('plan_type', 'invoice_detail.plan_type_id=plan_type.id')
                        ->leftJoin('status', 'status.id=invoice.status_id')
                        ->leftJoin('employee', 'employee.id=invoice.employee_id')
                        ->where(['invoice.company_id' => $companyId])
                        ->orderBy('datetime_created DESC')
                        ->asArray()
                        ->all();
    } 
    
    /**
     * Get invoice info
     * 
     * @param integer $id
     * @return array
     */
    public static function getById($id) {
          return self::find()
                ->select(['invoice.id', 'invoice.invoice_number', 'invoice.employee_id', 'invoice.company_id', 'invoice.expired_datetime', 'invoice.datetime_created AS invoice_datetime_created',
                            'invoice_detail.number_month', 'invoice_detail.max_user_register', 'invoice_detail.max_storage_register', 'invoice_detail.plan_type_id', 
                            'status.name AS status_name','status.column_name AS status_column_name', 'plan_type.name AS plan_type_name', 'plan_type.column_name AS plan_type_column_name',
                            'employee.firstname AS employee_firstname', 'employee.lastname AS employee_lastname', 'employee.mobile_phone AS employee_mobile_phone',
                            'employee.street_address_1 AS employee_street_address_1', 'employee.street_address_2 AS employee_street_address_2', 'employee.email AS employee_email',
                            'company.name as company_name', 'company.phone_no as company_phone_no'])
                        ->leftJoin('invoice_detail', 'invoice.id=invoice_detail.invoice_id')
                        ->leftJoin('plan_type', 'invoice_detail.plan_type_id=plan_type.id')
                        ->leftJoin('status', 'status.id=invoice.status_id')
                        ->leftJoin('employee', 'employee.id=invoice.employee_id')
                        ->leftJoin('company', 'company.id=invoice.company_id')
                        ->where(['invoice.id' => $id])
                        ->asArray()
                        ->one();
    }   
}
