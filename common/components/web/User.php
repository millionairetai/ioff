<?php

namespace common\components\web;

use Yii;

class User extends \yii\web\User 
{

    protected $_authority = [];

    public function can($action_permission = null, $params = [], $allowCaching = true) 
    {
//        return false;
        //In case if user is admin, allow all of system's action.
        if (Yii::$app->user->identity->is_admin) {
            return true;
        }

        //Get permission in case of user want to check authority with code, no check automatically.
        if (!$action_permission) {
            $action_permission = Yii::$app->controller->action->id;
        }

        //Get permission from cache before.
        if ($allowCaching && empty($params) && isset($this->_authority[Yii::$app->controller->id][$action_permission])) {
            return $this->_authority[Yii::$app->controller->id][$action_permission];
        }

        if (!$params) {
            $params = [
                'controller_name' => Yii::$app->controller->id,
            ];
        }

        $access = Yii::$app->authManager->checkAccess($this->getId(), $action_permission, $params);
        if ($allowCaching) {
            $this->_authority[Yii::$app->controller->id][$action_permission] = $access;
        }
        
        return $access;
    }

    public function beforeSave($insert) 
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }

            return true;
        }

        return false;
    }

}