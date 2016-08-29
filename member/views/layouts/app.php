<?php
/* @var $this \yii\web\View */
/* @var $content string */

use member\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo Html::csrfMetaTags() ?>
        <title><?php echo Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    </head>
    <body class="hold-transition sidebar-collapse skin-blue-light sidebar-mini" ng-app="iofficez" ng-controller="iofficezCtrl">
        <?php $this->beginBody() ?>
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php echo \member\widgets\Header::widget();?>
            <?php echo \member\widgets\Menu::widget();?>
            <?php echo $content ?>
            
            <div id="container-cover" ng-show="$root.progressing">
                <div id="cover-opacity"></div>
                <img src="img/ajax-loader.gif" style="" />
            </div>    
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>@iofficez</b>
                </div>
            </footer>
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>