<?php

namespace common\modules\authority;

use Yii;

class User extends \yii\web\User
{
    /**
     * Checks if the user can perform the operation as specified by the given permission.
     *
     * if super admin, the operation role is 'all', return true all the time.
     *
     *
     * @param string $permissionName the name of the permission (e.g. "edit post") that needs access check.
     * @param array $params name-value pairs that would be passed to the rules associated
     * with the roles and permissions assigned to the user. A param with name 'user' is added to
     * this array, which holds the value of [[id]].
     * @param boolean $allowCaching whether to allow caching the result of access check.
     * When this parameter is true (default), if the access check of an operation was performed
     * before, its result will be directly returned when calling this method to check the same
     * operation. If this parameter is false, this method will always call
     * [[\yii\rbac\ManagerInterface::checkAccess()]] to obtain the up-to-date access result. Note that this
     * caching is effective only within the same request and only works when `$params = []`.
     * @return boolean whether the user can perform the operation as specified by the given permission.
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if ($allowCaching && isset($this->_operations)) {
           $operations =  $this->_operations;
        } else {
            $operations = AuthRole::findOne(Yii::$app->user->identity->auth_role)->operation_list;
            $this->_operations = $operations;

            //super admin
            if ($operations == 'all')
                return true;
        }

        if (strpos(';' . $operations . ';', $permissionName) === false)
            return false;
        else
            return true;
    }
    
    public function checkAuthority($permissionName, $params = [], $allowCaching = true)
    {
        $params = [
                                'package' => Yii::$app->id,
                                'module'  => Yii::$app->module,
                                'controller' => Yii::$app->controller->id, 
                                'action' => Yii::$app->controller->action->id
                            ];
        
        return true;
        
        if ($allowCaching && empty($params) && isset($this->_access[$permissionName])) {
            return $this->_access[$permissionName];
        }
        
        $access = $this->getAuthManager()->checkAccess($this->getId(), $permissionName, $params);
        
        if ($allowCaching && empty($params)) {
            $this->_access[$permissionName] = $access;
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
