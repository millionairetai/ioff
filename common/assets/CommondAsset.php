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
    ];
    
    public $js = [
    	'js/jquery.js',
    	'js/jquery.min.js',
        'js/bootstrap/bootstrap.min.js',
        'js/jquery-ui.min.js',
        'js/raphael-min.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'plugins/fastclick/fastclick.js',
        'js/app.min.js',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'js/angular/angular.min.js',
        'js/angular/angular.js',
        'js/angular/angular-locale_vi-vn.js',
        'js/angular/ui-bootstrap-tpls-0.9.0.js',
    	'js/bootstrap-filestyle.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\AngularAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->basePath = str_replace(['work', 'hrm', 'kpi'], ['common'], Yii::getAlias("@webroot"));
        
    }
}
