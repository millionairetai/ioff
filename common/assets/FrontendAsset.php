<?php
namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class FrontendAsset extends AssetBundle
{
    public $basePath;
    public $baseUrl = '/frontend/app/';
    
    public $css = [];
    
    public $js = [
        'app.js',
        'components/filters.js',
        'services/common-service.js',
        'services/user-service.js',
        'services/auth-service.js',
        'modules/hrm/employee/router.js',
        'modules/hrm/employee/employee.js',
        'modules/hrm/employee/login/login.js',
        'modules/hrm/employee/logout/logout.js',
        'modules/work/project/router.js',
        'modules/work/project/project.js',
        'modules/work/project/home/home.js',
        'modules/work/project/report/report.js',
    ];  
    
    public $depends = [];
    
    public function __construct($config = array()) {
        parent::__construct($config);
        
        $lang = Yii::$app->language;
        $this->js[] = "languages/{$lang}.js";
        $this->basePath = str_replace(['frontend'], ['common'], Yii::getAlias("@webroot"));
    }
}
