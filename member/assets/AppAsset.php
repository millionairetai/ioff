<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace member\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'app/css/style.css',
        'css/AdminLTE.css',
        'css/all-skins.min.css',
        'css/font-awesome/css/font-awesome.css',
        'app/js/plugins/alertify/css/alertify.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/jquery.slimscroll.min.js',
        'js/fastclick.min.js',
        
        'app/js/common/angular.1.3.18.min.js',
        'app/js/common/angular-animate.1.3.18.min.js',
        'app/js/plugins/bootstrap/ui-bootstrap-tpls-0.13.3.min.js',
        'app/js/plugins/angularRoute/angular-route.min.js',
        'app/js/plugins/alertify/ngAlertify.js',
        'app/app.js',
        'app/router.js',
        'app/minify/minify_service.js',
        'app/minify/minify_controller.js',
        'app/minify/minify_directive.js',
        'app/minify/minify_filter.js',
        'js/app.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function __construct($config = array()) {
        parent::__construct($config);
        
        $lang = \Yii::$app->language;
        $this->js[] = "app/languages/{$lang}.js";
    }
}
