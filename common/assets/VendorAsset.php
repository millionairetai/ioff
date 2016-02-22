<?php
namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class VendorAsset extends AssetBundle
{
    public $basePath;
    public $baseUrl = '/vendor/bower/';
    
    public $css = [
        'angular-loading-bar/build/loading-bar.min.css',
        'alertify-js/build/css/alertify.min.css',
        'alertify-js/build/css/themes/default.min.css',
    ];
    
    public $js = [
        'bootstrap/dist/js/bootstrap.js',
        'angular-bootstrap/ui-bootstrap-tpls.min.js',
        'angular-sanitize/angular-sanitize.min.js',
        'angular-ui-router/release/angular-ui-router.js',
        'angular-loading-bar/build/loading-bar.js',
        'angular-cookies/angular-cookies.min.js',
        'alertify-js/build/alertify.min.js',
        'ng-file-upload/angular-file-upload-shim.min.js',
        'ng-file-upload/angular-file-upload.min.js',
        'angular-loading-bar/build/loading-bar.min.js',
    ];  
    
    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\AngularAsset'
//        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->basePath = str_replace(['frontend'], ['common'], Yii::getAlias("@webroot"));
    }
}
