<?php

namespace backend\components\web;

use Yii;

class User extends \yii\web\User 
{

    protected $_authority = [];

    public function can($controller = null, $action = null, $allowCaching = true) 
    {
//        return false;
        //In case if user is admin, allow all of system's action.
        if (Yii::$app->user->identity->is_admin) {
            return true;
        }

        //Get permission in case of user want to check authority with code, no check automatically.
        if (!$action) {
            $action = Yii::$app->controller->action->id;
        }

        //Get permission from cache before.
        if ($allowCaching && empty($controller) && isset($this->_authority[Yii::$app->controller->id][$action])) {
            return $this->_authority[Yii::$app->controller->id][$action];
        }

        if (!$controller) {
            $controller = Yii::$app->controller->id;
        }

        $access = Yii::$app->authManager->checkAccess($this->getId(), $action, $controller);
        if ($allowCaching) {
            $this->_authority[Yii::$app->controller->id][$action] = $access;
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
  
    /**
     * Returns a value of employee's company_id
     * @return integer
     */
    public function getCompanyId()
    {
        return $this->getIdentity();
    }
}