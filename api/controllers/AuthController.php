<?php

namespace api\controllers;

use Yii;
use api\models\LoginForm;
use common\models\Employee;
use common\helpers\JsonWebToken;
use yii\helpers\Security;
use common\components\web\AuthorityManager;

class AuthController extends ApiController {

    public function actionLogin() {
        if ($this->_request) {
            $loginForm = new LoginForm();
            $loginForm->username   = $this->_request['username'];
            $loginForm->password   = $this->_request['password'];
            $loginForm->rememberMe = $this->_request['rememberMe'];
            
            if ($loginForm->login()) {
                $employee = Employee::findOne(['username' => $this->_request['username']]);
                
                return self::sendOk([
                        'token' => JsonWebToken::createToken(['id' => $employee->id]),
                        'actions' => (new AuthorityManager())->getAssignments($employee->id),
                    ]);
            } else {
                return self::sendValidation($loginForm->getErrors());
            }
        }
    }
    
    public function actionForgotPassword() {
        if ($this->_request) {
            $user = User::findOne(['email' => $this->_request['email']]);
            if ($user) {
                $newPassword = Security::generateRandomKey(10);
                $user->password = Security::generatePasswordHash($newPassword);
                if ($user->save()) {
                    EmailHelper::sendNewPassword($user, $newPassword);
                }
            } else {
                return $this->send(StatusMessage::NOT_FOUND, ['email' => 'The email doesn\'t exist']);
            }
        }
    }
    
    public function actionLogout() {
        if (Yii::$app->user->logout()) {
            return self::sendOk(['success' => true]);
        }
        
        return self::send(StatusMessage::NOT_IMPLEMENTED, ['success' => false]);
    }
}
