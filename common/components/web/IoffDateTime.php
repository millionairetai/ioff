<?php

namespace common\components\web;

use Yii;
use DateTime;

class IoffDatetime extends \DateTime {
    
    public function getTimestamp () {
        return time();
    }
    
    public static function getTime ($format = 'H:i:s') {
        return date($format);
    }
    
    public static function getDate ($format = 'Y-m-d') {
        return date($format);
    }
    
    public static function getDateTime ($format = 'Y-m-d H:i:s') {
        return date($format);
    }
}
