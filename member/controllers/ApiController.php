<?php

namespace member\controllers;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use Yii;

class ApiController extends CommonController 
{
    //Company id.
    protected $_companyId;
    
    //Error message and error for calling restful.
    protected $_error = false;
    protected $_message = '';

    public function behaviors() 
    {
        $this->_companyId = \Yii::$app->user->getCompanyId();
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['login', 'error'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can();
                        },
                        'denyCallback' => function ($rule, $action) {
                            //Check again here
                            throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
                        }
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['get'],
//                ],
//            ],
        ];
    }

    /**
     * 
     * @param type $action
     * @return type
     */
//    public function beforeAction($action) {
//        if (Yii::$app->user->isGuest) {
//            $this->sendResponse(true, "", [], 203);
//        }
//        return parent::beforeAction($action);
//    }

}
