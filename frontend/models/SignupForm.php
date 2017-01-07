<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Employee;
use common\models\Company;
use common\models\Status;
use common\models\PlanType;

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
    public $plan_type_id;

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
            ['email', 'unique', 'targetClass' => '\common\models\Employee', 'message' => Yii::t('common','This email address has already been taken')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['rePassword', 'compare', 'compareAttribute'=>'password', 'message'=> Yii::t('common', "Passwords don't match"),],
            ['plan_type_id', 'required'],
            ['plan_type_id', 'integer',],
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
            'plan_type_id' => Yii::t('common', 'Plan type'),
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

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $company = new Company();
            $company->name = $this->companyName;
            $company->plan_type_id = $this->plan_type_id;
            
            //Get status of company which is active.
            $status = Status::getByOwnerTableAndColumnName('company', Company::COLUNM_NAME_ACTIVE);
            $company->status_id = $status['id'];
            
            //Get free plan type
            $freePlanType = PlanType::getByName(PlanType::FREE);
            if ($company->plan_type_id == $freePlanType['id']) {
                $company->start_date = time();;
            } else {
                $company->start_date = 0;
            }
            
            $company->expired_date = 0;
            if (!$company->save(false)) {
                throw new \Exception('Save data to company table fail');
            }

            $employee = new Employee();
            $employee->company_id = $company->id;
            $employee->authority_id = 1;
            
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
            
            //Send email to confirm.
            
            $transaction->commit();
            return true;
        } catch (Exception $ex) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }

}
