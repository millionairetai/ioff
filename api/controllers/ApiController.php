<?php

namespace api\controllers;

use \Yii;
use yii\web\Request;
use common\helpers\JsonWebToken;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\components\web\StatusMessage;

class ApiController extends \yii\rest\Controller
{
    /**
     *
     * @var mixed request data
     */
    protected $_request = null;
    
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

    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        
        if (!$this->_validateRequest()) {
            $this->send(StatusMessage::FORBIDDEN);
            Yii::$app->end();
        }

        $this->_getRequest();
    }

    /**
     * Send response ajax to client
     * 
     * @param integer $status
     * @param type $data
     * @param boolean If $isError is true, we will render data error of Yii to [key=>value]
     * 
     * @return void
     */
    public function send($status = self::OK, $data = null, $isError = false) {
        //Convert error's array to key => value to response to client.
        if ($isError) {
            $errors = [];
            foreach ($data as $fieldName => $itemErrors) {
                foreach ($itemErrors as $item) {
                    $errors[$fieldName] = $item;
                }
            }
            
            $data = $errors;
        }
        
        if ($status != StatusMessage::OK) {
            if ($data) {
                $data = is_string($data) ? [$data] : $data;
            } else {
                $data = ['ERROR_' . $status];
            }
        }
        
        Yii::$app->response->setStatusCode($status);

        return $data;
    }

    /**
     * Get request data from _request var
     * 
     * @param string $name
     * 
     * @return mixed
     */
    protected function getRequestParam($name) {
        return isset($this->_request[$name]) ? $this->_request[$name] : null;
    }

    /**
     * Set http status code
     * @param type $status
     */
    protected function setStatus($status = self::OK) {
        \Yii::$app->response->setStatusCode($status);
    }

    /**
     * Handle errors
     * we don't need to show system error to client, simply return 'error' string and html status code
     * 
     * @return string
     */
    public function actionError() {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $exception;
        }

        return null;
    }
    
    /**
     * Check if request is valid by comparing user id in token cookie and yii2 session server.
     *
     * @return void
     */
    private function _validateRequest() {
        if ($token = (new Request)->getHeaders()->get('Authorization')) {
            if (!$user = JsonWebToken::getData($token)) {
                return false;
            }
            
            if ($user->id != Yii::$app->user->identity->id) {
                return false;
            }
        }
        
        $request = Yii::$app->getRequest();
        if ($request->isPut || $request->isDelete) {
            if (!$user) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get raw body request from application/json request
     * 
     * @return void
     */
    private function _getRequest() {
        $request = Yii::$app->getRequest()->getRawBody();
        
        if (!empty($request)) {
            $this->_request = json_decode($request, true);
        }
    }
}