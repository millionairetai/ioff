<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Employee;
use common\models\Company;
use common\models\Status;
use common\models\PlanType;
use common\models\Order;
use common\models\OrderItem;
use common\models\Invoice;
use common\models\InvoiceDetail;
use common\models\EmailTemplate;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $companyName;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $rePassword;
    public $plan_type;
    public $maxUser = 0;
    public $maxStorage = 0;
    public $periodTime = 0;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['companyName', 'required'],
            ['companyName', 'filter', 'filter' => 'trim'],
            ['firstname', 'required'],
            ['firstname', 'filter', 'filter' => 'trim'],
            ['lastname', 'required'],
            ['lastname', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Employee', 'message' => Yii::t('common', 'This email address has already been taken')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['rePassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('common', "Passwords don't match"),],
            ['plan_type', 'required'],
            [['maxUser', 'maxStorage', 'periodTime'], 'integer',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'companyName' => Yii::t('common', 'Company name'),
            'firstname' => Yii::t('common', 'First name'),
            'lastname' => Yii::t('common', 'Last name'),
            'email' => Yii::t('common', 'Email'),
            'password' => Yii::t('common', 'Password'),
            'plan_type' => Yii::t('common', 'Plan type'),
        ];
    }

    /**
     * Signs new company up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $totalMoney = 0;
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //Write in company table.
            $company = new Company();
            $company->name = $this->companyName;
            $planType = PlanType::getsIndexByColumnName($this->plan_type);
            $company->plan_type_id = $planType[$this->plan_type]['id'];

            //Get status of company which is active.
            $status = Status::getByOwnerTableAndColumnName('company', Company::COLUNM_NAME_ACTIVE);
            $company->status_id = $status['id'];
            //Get free plan type
            if ($company->plan_type_id == $planType[PlanType::COLUMN_NAME_FREE]['id']) {
                $company->start_date = time();
            } else {
                $company->start_date = 0;
            }

            $company->expired_date = 0;
            if ($company->save(false) === false) {
                throw new \Exception('Save data to company table fail');
            }

            //Write in employee table.
            $employee = new Employee();
            $employee->company_id = $company->id;
            $employee->authority_id = 0;

            //Get status of employee which is active.
            $status = Status::getByOwnerTableAndColumnName('employee', Employee::COLUNM_NAME_ACTIVE);
            $employee->status_id = $status['id'];
            $employee->email = $this->email;
            $employee->is_admin = true;
            $employee->firstname = $this->firstname;
            $employee->lastname = $this->lastname;
            $employee->last_activity_datetime = time();
            $employee->last_ip_address = Yii::$app->request->getUserIP();
            $employee->setPassword($this->password);
            $employee->generateAuthKey();
            if (!$employee->save(false)) {
                throw new \Exception('Save data to employee table fail');
            }

            //Update person create this company.
            $company->created_employee_id = $employee->id;
            $company->lastup_employee_id = $employee->id;
            if (!$company->save(false)) {
                throw new \Exception('Save employee id data to company table fail');
            }

            //Write in order and invoice
            $this->_insertOrderInvoice($company, $employee, $planType);

            //Send email to confirm.
            if ($company->plan_type_id == $planType[PlanType::COLUMN_NAME_FREE]['id']) {
                $themeEmail = EmailTemplate::getTheme(EmailTemplate::SUCCESS_COMPANY_REGISTRATION_FREE);
            } else {
                $themeEmail = EmailTemplate::getTheme(EmailTemplate::SUCCESS_COMPANY_REGISTRATION);
            }

            //Get total money.
            switch ($this->plan_type) {
                case 'free':
                    $totalMoney = 0;
                    break;
                case 'standard':
                    $totalMoney = $planType[$this->plan_type]['fee_user'] * $this->periodTime + $planType[$this->plan_type]['fee_storage'] * $this->periodTime;
                    break;
                case 'premium':
                    $totalMoney = $planType[$this->plan_type]['fee_user'] + $planType[$this->plan_type]['fee_storage'] * $this->periodTime;
                    break;
            }
            $dataSend = [
                '{fullname}' => $employee->fullname,
                '{name service}' => $company->name,
                '{package name}' => $planType[$this->plan_type]['name'],
                '{max user}' => !empty($this->maxUser) ? $this->maxUser : strtolower(Yii::t('common', 'Unlimited')),
                '{max storage}' => $this->maxStorage,
                '{total money}' => $totalMoney,
                '{number credit card}' => Yii::$app->params['number_credit_card'],
                '{support email}' => Yii::$app->params['support_email'],
                '{hot line number}' => Yii::$app->params['hot_line_number'],
                '{period time}' => $this->periodTime
            ];

            $employee->sendMail($dataSend, $themeEmail);
            $transaction->commit();
            return true;
        } catch (Exception $ex) {
            $transaction->rollBack();
            return false;
        }

        return true;
    }

    private function _insertOrderInvoice($company, $employee, $planType) {
        $order = new Order();
        $order->company_id = $company->id;
        $order->order_number = 15000 + (int) $company->id;
        $order->employee_id = $employee->id;
        //Get status for order.
        if ($company->plan_type_id == $planType[PlanType::COLUMN_NAME_FREE]['id']) {
            $status = Status::getByOwnerTableAndColumnName('order', Order::COLUNM_NAME_PAYED);
            $order->expired_datetime = 0;
            $order->duedate = 0;
        } else {
            $status = Status::getByOwnerTableAndColumnName('order', Order::COLUNM_NAME_WAIT_PAY);
            $order->expired_datetime = 0;
            $order->duedate = 0;
        }

        $order->status_id = $status['id'];
        if ($order->save(false) === false) {
            throw new \Exception('Save data to order table fail');
        }

        //Insert into order item.
        $orderItem = new OrderItem();
        $orderItem->company_id = $company->id;
        $orderItem->order_id = $order->id;
        $orderItem->plan_type_id = $planType[$this->plan_type]['id'];
        /////////////////
        $orderItem->period_time_id = !empty($this->periodTime) ? $this->periodTime : 0;
        $orderItem->max_user_register = $this->maxUser;
        $orderItem->max_storage_register = $this->maxStorage;
        $orderItem->discount = 0;
        if ($orderItem->save(false) === false) {
            throw new \Exception('Save data to order item table fail');
        }

        if ($company->plan_type_id != $planType[PlanType::COLUMN_NAME_FREE]['id']) {
            return true;
        }

        $invoice = new Invoice();
        $invoice->company_id = $company->id;
        $invoice->invoice_number = 15000 + (int) $company->id;
        //Get status of employee which is active.
        $status = Status::getByOwnerTableAndColumnName('invoice', Invoice::COLUNM_NAME_PAYED);
        $invoice->status_id = $status['id'];
        $invoice->order_id = $order->id;
        $invoice->employee_id = $employee->id;
        if ($invoice->save(false) === false) {
            throw new \Exception('Save data to invoice table fail');
        }

        $invoiceDetail = new InvoiceDetail();
        $invoiceDetail->company_id = $company->id;
        $invoiceDetail->invoice_id = $invoice->id;
        $invoiceDetail->period_time_id = 0;
        $invoiceDetail->plan_type_id = $planType[$this->plan_type]['id'];
        $invoiceDetail->max_user_register = $this->maxUser;
        $invoiceDetail->max_storage_register = $this->maxStorage;
        if ($invoiceDetail->save(false) === false) {
            throw new \Exception('Save data to invoice detail table fail');
        }

        return true;
    }

}
