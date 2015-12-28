<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\assets\CommondAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

CommondAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <!--    <body class="hold-transition skin-blue-light sidebar-mini">-->
    <body class="hold-transition login-page">
        <?php $this->beginBody() ?>
        <div class="login-box">
            <div class="login-box-body">
                <div class="login-logo">
                    <a href><b>Center</b>Office</a>
                </div>
                <!-- /.login-logo -->
                <!--<p class="login-box-msg"></p>-->
                <?= $content ?>
                <a href="#"><?= Yii::t('common', 'I forgot my password'); ?></a><br>
            </div>
            <!-- /.login-box-body -->
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
