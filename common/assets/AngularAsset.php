<?php
namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $js = [
        'angular/angular.min.js',
//        'angular-route/angular-route.js',
    ];
}
