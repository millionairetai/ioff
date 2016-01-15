<?php
namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class CommonVendor extends AssetBundle
{
    public $basePath;
    public $baseUrl = '/vendor/bower/';
    
    public $css = [
    		'works/calendar/css/fullcalendar.css',
//     		'works/calendar/css/fullcalendar.print.css',
    		'works/calendar/css/fullcalendar.min.css',
    		
    		'works/calendar/css/datetimepicker/bootstrap-datetimepicker.css',
    		'works/calendar/css/fileinput.css',
    ];
    
    public $js = [
    		'works/calendar/js/moment.js',
    		'works/calendar/js/calendar.js',
    		'works/calendar/js/calendarDemo.js',
    		'works/calendar/js/fullcalendar.js',
    		'works/calendar/js/fullcalendar.min.js',
    		'works/calendar/js/gcal.js',
    		'works/calendar/js/moment.min.js',
    		
    		'works/calendar/js/datetimepicker/bootstrap-datetimepicker.js',
    		'works/calendar/js/datetimepicker/datetimeCustomize.js',
    		'works/calendar/js/fileinput.js',
    		
    ];
    
    public $depends = [
    		'yii\web\YiiAsset',
    ];
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->basePath = str_replace(['work', 'hrm', 'kpi'], ['common'], Yii::getAlias("@webroot"));
    }
}
