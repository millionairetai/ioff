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
    
    public $js = [];  
    
    public $depends = [];
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->basePath = str_replace(['frontend'], ['common'], Yii::getAlias("@webroot"));
        
    }
}
