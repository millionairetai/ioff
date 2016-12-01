<?php

namespace member\models;

use Yii;
use yii\base\Model;
use common\models\Employee;
use common\models\Status;
use common\models\EmailTemplate;
use common\models\Activity;

/**
 * Registration form
 */
class RegistrationForm extends Model {

    public $email;
    public $firstName;
    public $lastName;
    public $password;
    public $rePassword;
    public $agree = false;
    private $_employee;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'min' => 5, 'max' => 99],
            
            ['firstName', 'filter', 'filter' => 'trim'],
            ['firstName', 'required'],
            ['firstName', 'string', 'max' => 99],
            
            ['lastName', 'filter', 'filter' => 'trim'],
            ['lastName', 'required'],
            ['lastName', 'string', 'max' => 99],
            
            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 40],
            ['password', 'compare', 'compareAttribute' => 'rePassword', 'message' => Yii::t('common', 'Passwords do not match together')],
            
            ['rePassword', 'filter', 'filter' => 'trim'],
            ['rePassword', 'required'],
            ['rePassword', 'string', 'min' => 6, 'max' => 40],
            
            ['agree', 'required'],
            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue' => true, 'operator' => '==', 'message' => Yii::t('member', 'You do not agree to terms')],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => Yii::t('common', 'Email'),
            'firstName' => Yii::t('common', 'First name'),
            'lastName' => Yii::t('common', 'Last name'),
            'agree' => Yii::t('member', 'I agree'),
            'password' => Yii::t('common', 'Password'),
            'rePassword' => Yii::t('common', 'Re-Password'),
        ];
    }

    /**
     * Get information of employee who's invited.
     *
     * @param string $emails
     * @param string $token
     * @return boolean
     */
    public function getInvitedEmployee($email, $token) {
        if ($this->_employee = Employee::getInvitedInfo($email, $token)) {
            $this->email = $this->_employee->email;
            return true;
        }

        return false;
    }

    /**
     * Sign up for new employee
     * @return object|boolean
     */
    public function signup() {
        $this->_employee->firstname = $this->firstName;
        $this->_employee->lastname = $this->lastName;
        $this->_employee->removePasswordResetToken();
        $this->_employee->setPassword($this->password);
        $this->_employee->generateAuthKey();
        $transaction = \Yii::$app->db->beginTransaction();
        
        try {
            //Update again status to active
            if (!$status = Status::getByOwnerTableAndColumnName('employee', Employee::COLUNM_NAME_ACTIVE)) {
                throw new Exception('Can not get status');
            }

            $this->_employee->status_id = $status['id'];
            if (!$this->_employee->save(false)) { 
                throw new \Exception('Can not save employee');
            }
            
            //Write in activity table.
            $activity = new Activity();
            $activity->company_id = $this->_employee->company_id;
            $activity->owner_id = $this->_employee->id;
            $activity->owner_table = Activity::TABLE_EMPLOYEE;
            $activity->parent_employee_id = 0;
            $activity->employee_id = 0;
            $activity->type = Activity::TYPE_REGISTER_ACCOUNT;
            $activity->content = $this->_employee->fullname . ' join our intranet';
            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }

            $this->_employee->password = $this->password;
            //send email
            $dataSend = [
                '{employee name}' => $this->_employee->fullname,
                '{account}' => $this->email,
                '{password}' => $this->password,
            ];

            $this->_employee->sendMail($dataSend, EmailTemplate::getTheme(EmailTemplate::SUCCESS_EMPLOYEE_REGISTRATION));
            $transaction->commit();
            return $this->_employee;
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return false;
        }
        
        return false;
    }

}
