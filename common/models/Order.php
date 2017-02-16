<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

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
    const COLUNM_NAME_PAYED = 'order.payed';
    const COLUNM_NAME_PENDING = 'order.pending';
    
    public $company_name;
    public $number_month;
    public $max_user_register;
    public $max_storage_register;
    public $status_name;
    public $plan_type_name;

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
            [['disabled'], 'boolean'],
            
            [['company_name', 'status_name', 'plan_type_name'], 'string'],
            [['number_month', 'max_user_register' , 'max_storage_register'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => Yii::t('common', 'Company name'),
            'order_number' => Yii::t('common', 'Order Number'),
            'employee_id' => Yii::t('common', 'Employee'),
            'status_id' => Yii::t('common', 'Status'),
            
            'expired_datetime' => Yii::t('common', 'Expired Datetime'),
            'company_name' => Yii::t('common', 'Company name'),
            'number_month' => Yii::t('common', 'Number month'),
            'status_name' => Yii::t('common', 'Status'),
            'max_user_register' => Yii::t('common', 'Max user register'),
            'max_storage_register' => Yii::t('common', 'Max storage register'),
            'plan_type_name' => Yii::t('common', 'Plan type'),

//            'duedate' => Yii::t('member', 'Duedate'),
//            'datetime_created' => Yii::t('member', 'Datetime Created'),
//            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
//            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
//            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
//            'disabled' => Yii::t('member', 'Disabled'),
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
    
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = self::find()
                ->select(['order.id', 'order.order_number', 'order.expired_datetime', 'order_item.number_month', 'order_item.max_user_register', 
                    'order_item.max_storage_register', 'company.name as company_name', 
                    'status.name AS status_name', 'plan_type.name AS plan_type_name'])
                ->leftJoin('company', 'company.id=order.company_id')
                ->leftJoin('order_item', 'order.id=order_item.order_id')
                ->leftJoin('status', 'status.id=order.status_id')
                ->leftJoin('plan_type', 'order_item.plan_type_id=plan_type.id')
                ->orderBy('order.datetime_created DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 20)
        ]);

        if (!($this->load($params))) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'company.name', $this->company_name]);
        $query->andFilterWhere(['like', 'order.order_number', $this->order_number]);
        $query->andFilterWhere(['like', 'order_item.number_month', $this->number_month]);
        $query->andFilterWhere(['like', 'order_item.max_user_register', $this->max_user_register]);
        $query->andFilterWhere(['like', 'order_item.max_storage_register', $this->max_storage_register]);
        $query->andFilterWhere(['like', 'status.name', $this->status_name]);
        $query->andFilterWhere(['like', 'plan_type.name', $this->plan_type_name]);

        return $dataProvider;
    }

    /**
     * Get order info
     * 
     * @param integer $id
     * @return array
     */
    public static function getOrderInfoById($id) {
          return self::find()
                ->select(['order.id', 'order.order_number', 'order.employee_id', 'order.company_id', 'order.expired_datetime',
                            'order_item.number_month', 'order_item.max_user_register', 'order_item.max_storage_register', 'order_item.plan_type_id', 
                            'status.name AS status_name','status.column_name AS status_column_name', 'plan_type.name AS plan_type_name', 'plan_type.column_name AS plan_type_column_name',
                            'employee.firstname AS employee_firstname', 'employee.lastname AS employee_lastname', 'employee.mobile_phone AS employee_mobile_phone',
                            'employee.street_address_1 AS employee_street_address_1', 'employee.street_address_2 AS employee_street_address_2', 'employee.email AS employee_email',
                            'company.name as company_name'])
                        ->leftJoin('order_item', 'order.id=order_item.order_id')
                        ->leftJoin('plan_type', 'order_item.plan_type_id=plan_type.id')
                        ->leftJoin('status', 'status.id=order.status_id')
                        ->leftJoin('employee', 'employee.id=order.employee_id')
                        ->leftJoin('company', 'company.id=order.company_id')
                        ->where(['order.id' => $id])
                        ->asArray()
                        ->one();
    }    
}
