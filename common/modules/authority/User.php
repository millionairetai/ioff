<?php

namespace common\modules\authority;

use Yii;

class User extends \yii\web\User
{
    protected $_authority = [];
    
    public function can($action_permission = null, $params= [], $allowCaching = true)
    {
        //In case if user is admin, allow all of system's action.
        if (Yii::$app->user->identity->is_admin) 
        {
            return true;
        }
        
        //Get permission in case of user want to check authority with code, no check automatically.
        if (!$action_permission) 
        {
            $action_permission = Yii::$app->controller->action->id;
        }
        
        //Get permission from cache before.
        if ($allowCaching && empty($params) && isset($this->_authority[$action_permission])) {
            return $this->_authority[Yii::$app->id][Yii::$app->controller->module->id][Yii::$app->controller->id][$action_permission];
        }
        
        $params = [
            'package_name'    => Yii::$app->id,
            'module_name'     => Yii::$app->controller->module->id,
            'controller_name' => Yii::$app->controller->id, 
        ];
        
        $access = Yii::$app->authManager->checkAccess($this->getId(), $action_permission, $params);
        if ($allowCaching) {
            $this->_authority[Yii::$app->id][Yii::$app->controller->module->id][Yii::$app->controller->id][$action_permission] = $access;
        }

        return $access;
    }


    /**
     * Redirects the user browser to the login page of common package 
     *
     * Before the redirection, the current URL (if it's not an AJAX url) will be kept as [[returnUrl]] so that
     * the user browser may be redirected back to the current page after successful login.
     *
     * Make sure you set [[loginUrl]] so that the user browser can be redirected to the specified login URL after
     * calling this method.
     *
     * Note that when [[loginUrl]] is set, calling this method will NOT terminate the application execution.
     *
     * @param boolean $checkAjax whether to check if the request is an AJAX request. When this is true and the request
     * is an AJAX request, the current URL (for AJAX request) will NOT be set as the return URL.
     * @return Response the redirection response if [[loginUrl]] is set
     * @throws ForbiddenHttpException the "Access Denied" HTTP exception if [[loginUrl]] is not set
     */
    public function loginRequired($checkAjax = true)
    {
        $request = Yii::$app->getRequest();
        if ($this->enableSession && (!$checkAjax || !$request->getIsAjax())) {
            $this->setReturnUrl($request->getUrl());
        }
        
        if ($this->loginUrl !== null) {
            $loginUrl = (array) $this->loginUrl;
           
            if ($loginUrl[0] !== Yii::$app->requestedRoute) {
                return Yii::$app->getResponse()->redirect('/common/web/index.php?r=site/login');
            }
        }
        
        throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'Login Required'));
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
