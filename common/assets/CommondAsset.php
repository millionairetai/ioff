<?php
namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class CommondAsset extends AssetBundle
{
    public $basePath;
    public $baseUrl = '/common/web/';
    
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'plugins/iCheck/flat/blue.css',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        'css/site.css',
        'css/fullcalendar.css',
        'css/fullcalendar.print.css',
    ];
    
    public $js = [
        'js/bootstrap/bootstrap.min.js',
        'js/jquery-ui.min.js',
        'js/raphael-min.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'plugins/fastclick/fastclick.js',
        'js/app.min.js',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'js/moment.min.js',
        'js/fullcalendar.min.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->basePath = str_replace(['work', 'hrm', 'kpi'], ['common'], Yii::getAlias("@webroot"));
        
    }
}
