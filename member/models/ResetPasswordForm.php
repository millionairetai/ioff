<?php

namespace member\models;

use common\models\Employee;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model {

    public $password;
    public $rePassword;

    /**
     * @var \common\models\Employee
     */
    public $employee;

    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\Exception if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        
        $this->employee = Employee::findByPasswordResetToken($token);
        if (!$this->employee) {
            throw new \Exception('Wrong password reset token.');
        }
        
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'string', 'min' => 6, 'max' => 64],
            ['password', 'compare', 'compareAttribute' => 'rePassword', 'message' => Yii::t('common', 'Passwords do not match together')],
            
            ['rePassword', 'required'],
            ['rePassword', 'string', 'min' => 6, 'max' => 64],
        ];
    }
    
    public function attributeLabels() {
        return [
            'password' => Yii::t('common', 'Password'),
            'rePassword' => Yii::t('common', 'Re-Password'),
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword() {
        $employee = $this->employee;
        $employee->setPassword($this->password);
        $employee->removePasswordResetToken();

        return $employee->save(false);
    }

}
