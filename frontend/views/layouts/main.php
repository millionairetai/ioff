
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\assets\CommondAsset;
use common\assets\CommonVendor;
use yii\helpers\Html;
use yii\web\View;
CommondAsset::register($this);
CommonVendor::register($this);
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
        <link rel='stylesheet' href='/vendor/bower/angular-loading-bar/build/loading-bar.min.css' type='text/css' media='all' />    
        <link rel="stylesheet" href="/vendor/bower/alertify-js/build/css/alertify.min.css" />
        <link rel="stylesheet" href="/vendor/bower/alertify-js/build/css/themes/default.min.css" />
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

        <?php $this->endBody() ?>
        <script type="text/javascript">
            var SITE_URL = "<?php echo  SITE_URL; ?>";
        </script>  
        <script src="/vendor/bower/bootstrap/dist/js/bootstrap.js"></script>  
        <script src="/vendor/bower/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>        
        <script src="/vendor/bower/angular-sanitize/angular-sanitize.min.js"></script>    
        <script src="/vendor/bower/angular-ui-router/release/angular-ui-router.js"></script>
        <script src="/vendor/bower/angular-loading-bar/build/loading-bar.js"></script>
        <script src="/vendor/bower/angular-cookies/angular-cookies.min.js"></script>
        <script src="/vendor/bower/alertify-js/build/alertify.min.js"></script>
        <script src="/vendor/bower/ng-file-upload/angular-file-upload-shim.min.js"></script>
        <script src="/vendor/bower/ng-file-upload/angular-file-upload.min.js"></script> 
        <script src="/vendor/bower/angular-loading-bar/build/loading-bar.min.js"></script>
        <script src="/frontend/app/app.js"></script>
        
        <script src="/frontend/app/components/filters.js"></script>
        
        <script src="/frontend/app/services/common-service.js"></script>
        <script src="/frontend/app/services/user-service.js"></script>
        <script src="/frontend/app/services/auth-service.js"></script>
        
        <script src="/frontend/app/modules/hrm/employee/router.js"></script>
        <script src="/frontend/app/modules/hrm/employee/employee.js"></script>
        <script src="/frontend/app/modules/hrm/employee/login/login.js"></script>
        <script src="/frontend/app/modules/hrm/employee/logout/logout.js"></script>
        <script src="/frontend/app/modules/work/project/router.js"></script>
        <script src="/frontend/app/modules/work/project/project.js"></script>
        <script src="/frontend/app/modules/work/project/home/home.js"></script>
        <script src="/frontend/app/languages/<?= \Yii::$app->language;  ?>.js"></script>
    </body>
</html>
<?php $this->endPage() ?>