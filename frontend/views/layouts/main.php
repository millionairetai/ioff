<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\assets\CommondAsset;
use common\assets\VendorAsset;
use common\assets\FrontendAsset;
use yii\helpers\Html;
use yii\web\View;

CommondAsset::register($this);
VendorAsset::register($this);
FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" xmlns:ng="http://angularjs.org/" ng-app="centeroffice">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Centerofficee is the system for company, organization" >   
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="Centeroffice"/>
        <meta property="og:image" content=""/>
        <meta property="og:description" content="Centerofficee is the system for company, organization"/>
        <base href="<?php echo SITE_URL; ?>">   
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <![endif]-->
    </head>
    <!--<body ng-class="{'hold-transition skin-blue-light sidebar-mini' : token, 'hold-transition login-page' : !token:}" class="">-->
    <body class="hold-transition skin-blue-light sidebar-mini" ng-controller="ce_controller">
        <?php $this->beginBody() ?>
        <div ng-if="token" class="wrapper">
            <ng-include src="'/frontend/app/partials/header.html'"></ng-include>
            <ng-include src="'/frontend/app/partials/left-menu.html'"></ng-include>
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <ng-include src="'/frontend/app/partials/breadcrumb.html'"></ng-include>
                <!-- Main content -->
                <section class="content">
                    <?= $content ?>
                    <ui-view></ui-view>  
                </section>
            </div>
        </div>
        
        <div ng-if="!token" class="wrapper">
            <section class="login-box">
                <?= $content ?>
                <ui-view></ui-view>  
            </section>
        </div>

        <script type="text/javascript">
            var SITE_URL = "<?php echo  SITE_URL; ?>";
        </script>
        <?php $this->endBody() ?>  
    </body>
</html>
<?php $this->endPage() ?>