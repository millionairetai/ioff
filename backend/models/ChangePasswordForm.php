<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Change password form
 */
class ChangePasswordForm extends Model {

    public $id;
    public $oldPassword;
    public $newPassword;
    public $rePassword;
    private $_staff;

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
            ['newPassword', 'match', 'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', 'message' => Yii::t('backend', 'Password must be minimum 8 characters at least 1 alphabet and 1 number')],
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
            $employee = $this->getStaff();
            if (!$employee || !$employee->validatePassword($this->oldPassword)) {
                $this->addError($attribute, Yii::t('common', 'Current password wrong'));
            }
        }
    }

    /**
     * Change password
     * @param integer $id
     * @return boolean
     */
    public function changePassword($id) {
        $this->id = $id;            

        if ($this->validate()) {
            if ($this->_staff === null) {
                $this->getStaff();
            }
            
            if ($this->_staff) {
                $this->_staff->password = $this->newPassword;
//                $this->_staff->removePasswordResetToken();
                $this->_staff->setPassword($this->newPassword);
//                $this->_staff->generateAuthKey();
                
                if (!$this->_staff->save(false)) { 
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
    protected function getStaff(){
        if ($this->_staff === null) 
        {
            $this->_staff = Staff::getById($this->id);
        }

        return $this->_staff;
    }

}
