<?php
namespace member\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/AdminLTE.css',
        'css/all-skins.min.css',
        'css/font-awesome/css/font-awesome.css',
        'app/js/plugins/alertify/css/alertify.css',
        'app/js/plugins/uiSlider/jquery-ui.css',
        'app/js/plugins/uiSlider/slider.css',
        'app/js/plugins/icheck/all.css',
        'app/js/plugins/select/select.css',
        'app/js/plugins/tags/tags.css',
        'app/js/plugins/tags/tags-bootstrap.css',
        'app/js/plugins/fullcalendar/dist/fullcalendar.css',
        'app/css/style.css',
        'app/css/reponsive.css'
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/jquery.slimscroll.min.js',
        /*'js/fastclick.min.js',*/
        'app/js/common/angular-1.4.8.min.js',
        //'app/js/common/angular-animate.1.3.18.min.js',
        'app/js/plugins/bootstrap/ui-bootstrap-tpls-1.3.2.min.js',
        'app/js/plugins/angularRoute/angular-route.min.js',
        'app/js/common/angular-ui-router.min.js',
        'app/js/plugins/alertify/ngAlertify.js',
        'app/js/plugins/uiSlider/jquery-ui.min.js',
        'app/js/plugins/uiSlider/slider.js',
        'app/js/plugins/icheck/icheck.min.js',
        'app/js/plugins/autoNumeric/autoNumeric.js',
        'app/js/plugins/select/select.js',
        'app/js/plugins/tags/tags.js',
        'app/js/plugins/moment/min/moment.min.js',
        'app/js/plugins/fullcalendar/dist/fullcalendar.min.js',
        'app/js/plugins/fullcalendar/dist/lang-all.js',
        'app/js/plugins/fullcalendar/dist/gcal.js',
        'app/js/plugins/angular-ui-calendar/src/calendar.js',
        'app/js/plugins/datetime/datetime-picker.js',
        'app/js/plugins/socket/socket.js',
        'app/js/plugins/tinymce/tinymce.min.js',
        'app/js/plugins/tinymce/ng-tinymce.js',
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
        $this->js[] = "app/languages/date/{$lang}.js";
    }
}
