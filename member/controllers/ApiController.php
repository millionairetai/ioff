<?php

namespace member\controllers;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use Yii;

class ApiController extends CommonController 
{

    public function behaviors() 
    {
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
