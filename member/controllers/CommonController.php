<?php

namespace member\controllers;

use Yii;
use yii\web\Controller;

class CommonController extends Controller
{
    
    const OK                    = 200;
    const BAD_REQUEST           = 400;
    const UNAUTHORIED           = 401;
    const PAYMENT_REQUIRED      = 402;
    const FORBIDDEN             = 403;
    const NOT_FOUND             = 404;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED       = 501;
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * 
     * @param type $status
     * @return type
     */
    protected function _getStatusCodeMessage($status) {
        $codes = Array(
            self::OK => 'OK',
            self::BAD_REQUEST => 'Bad Request',
            self::UNAUTHORIED => 'Unauthorized',
            self::PAYMENT_REQUIRED => 'Payment Required',
            self::FORBIDDEN => 'Forbidden',
            self::NOT_FOUND => 'Not Found',
            self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
            self::NOT_FOUND => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /**
     * 
     */
    protected function parserMessage($messages) {
        $message_string = "";
        if(is_array($messages)){
            foreach ($messages as $values) {
                if (is_array($values)) {
                    foreach($values as $item){
                        $message_string .= $item . "<br/>";
                    }
                } else {
                    $message_string .= $values . "<br/>";
                }
            }
        }else{
            $message_string = $messages;
        }
        
        return $message_string;
    }
    
    /**
     * 
     */
    protected function sendResponse($error,$message,$objects,$code = self::OK){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        \Yii::$app->response->setStatusCode($code);
        $result = ['error' => $error,'message' => $message,'objects' => $objects];
        return $result;
    }
    
    /**
     * 
     */
    protected function getPagination($sql,&$currentPage,$itemPerPage,$params){
        $countSql = preg_replace('/SELECT(.*?)FROM/','SELECT COUNT(*) FROM ',$sql);
        $countCommand = \Yii::$app->getDb()->createCommand($countSql)->bindValues($params);//var_dump($countSql);die;
        $totalItems = $countCommand->queryScalar();
        /*$totalPages = ((int)($totalItems / $itemPerPage)) + (($totalItems % $itemPerPage) > 0?1:0);
        if($currentPage > $totalPages){
            $currentPage = $totalPages;
        }
        if($currentPage < 1){
            $currentPage = 1;
        }*/
        return $totalItems;
    }
}