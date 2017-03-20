<?php

namespace member\models;

use Yii;
use yii\base\Model;
use common\models\Employee;
use common\models\EmailTemplate;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\Employee',
                'filter' => ['status_id' => Employee::STATUS_ACTIVE],
                'message' => Yii::t('member', 'There is no user with such email')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail() {
        $employee = Employee::findOne([
            'status_id' => Employee::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$employee) {
            return false;
        }

        if (!Employee::isPasswordResetTokenValid($employee->password_reset_token)) {
            $employee->generatePasswordResetToken();
        }

        if (!$employee->save()) {
            return false;
        }
        
        //Make link to reset password
        $dataSend = [
            '{employee name}' => $employee->fullname,
            '{link}' => \Yii::$app->params['companyDomain'] . '/index/reset-password?token=' . $employee->password_reset_token,
            '{support email}' => \Yii::$app->params['support_email'],
            '{service}' => \Yii::$app->params['service']
        ];

        return $employee->sendMail($dataSend, EmailTemplate::getTheme(EmailTemplate::REQUEST_PASSWORD_AGAIN));
    }

}
