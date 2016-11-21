<?php

namespace member\models;

use Yii;
use yii\base\Model;
use common\models\Employee;

/**
 * Registration form
 */
class RegistrationForm extends Model
{
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
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            ['agree', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'rememberMe' => Yii::t('common', 'Remember me'),
            'username'   => Yii::t('common', 'Username'),
            'password'   => Yii::t('common', 'Password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $staff = $this->getStaff();
            if (!$staff || !$staff->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('common', 'Incorrect username or password'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) 
        {
            return Yii::$app->user->login($this->getStaff(),$this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getStaff()
    {
        if ($this->_staff === null) 
        {
            $this->_staff = Staff::findByUsername($this->username);
        }

        return $this->_staff;
    }
    
    
    /**
     * Validate invited info for new employee
     *
     * @param string $emails
     * @param string $token
     * @return boolean
     */
    public function getInvitedInfo($email, $token) {
        return true;
    }
    
    /**
     * Validate invited info for new employee
     *
     * @param string $emails
     * @param string $token
     * @return boolean
     */
    public function save($emplyee) {
        return true;
    }
}
