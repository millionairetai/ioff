<?php

namespace frontend\assets;

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
        'css/bootstrap.min.css',
        'css/reset.css',
        'css/common.css',
        'css/style.css',
        'js/plugin/ionslider/ion.rangeSlider.skinNice.css',
        'js/plugin/ionslider/ion.rangeSlider.css',
        'js/plugin/bootstrap-slider/slider.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/plugin/ionslider/ion.rangeSlider.min.js',
        'js/plugin/bootstrap-slider/bootstrap-slider.js',
        'js/fixHeight.js',
        'js/common.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
