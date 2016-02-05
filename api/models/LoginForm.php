<?php

namespace api\models;

use Yii;
use yii\base\Model;
use common\models\Employee;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_employee;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
//             ['username', 'email'],
            ['rememberMe', 'boolean'],
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
            $employee = $this->getEmployee();
            if (!$employee || !$employee->validatePassword($this->password)) {
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
            return Yii::$app->user->login($this->getEmployee(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getEmployee()
    {
        if ($this->_employee === null) 
        {
            $this->_employee = Employee::findByUsername($this->username);
        }

        return $this->_employee;
    }
}
