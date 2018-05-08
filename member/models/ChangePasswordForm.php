<?php

namespace member\models;

use Yii;
use yii\base\Model;
use common\models\Employee;

/**
 * Change password form
 */
class ChangePasswordForm extends Model {

    public $id;
    public $oldPassword;
    public $newPassword;
    public $rePassword;
    private $_employee;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // password is validated by validatePassword()
            ['oldPassword', 'filter', 'filter' => 'trim'],
            ['oldPassword', 'required'],
            ['oldPassword', 'validatePassword'],
            
            ['newPassword', 'filter', 'filter' => 'trim'],
            ['newPassword', 'required'],
            ['newPassword', 'string', 'min' => 6, 'max' => 64],
            ['newPassword', 'compare', 'compareAttribute' => 'rePassword', 'message' => Yii::t('common', 'Passwords do not match together')],
            
            ['rePassword', 'filter', 'filter' => 'trim'],
        ];
    }

    public function attributeLabels() {
        return [
            'oldPassword' => Yii::t('common', 'Current password'),
            'newPassword' => Yii::t('common', 'New password'),
            'rePassword' => Yii::t('common', 'ReNew Password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $employee = $this->getEmployee();
            if (!$employee || !$employee->validatePassword($this->oldPassword)) {
                $this->addError($attribute, Yii::t('common', 'Current password wrong'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function changePassword($id) {
        $this->id = $id;            

        if ($this->validate()) {
            if ($this->_employee === null) {
                $this->getEmployee();
            }
            
            if ($this->_employee) {
                $this->_employee->password = $this->newPassword;
                $this->_employee->removePasswordResetToken();
                $this->_employee->setPassword($this->newPassword);
                $this->_employee->generateAuthKey();
                
                if (!$this->_employee->save(false)) { 
                    return false;
                }
            }
            
            return true;
        }
        
        return false;
    }
        
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getEmployee(){
        if ($this->_employee === null) 
        {
            $this->_employee = Employee::getById($this->id);
        }

        return $this->_employee;
    }

}
