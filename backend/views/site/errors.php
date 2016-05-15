<?php

use yii\helpers\Url;
?>
<section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> <?php echo \Yii::t('common', 'Oops! Page not found.');?></h3>

          <p>
            <?php echo \Yii::t('common', 'We could not find the page you were looking for.');?>
            <?php echo \Yii::t('common', 'Meanwhile, you may');?> <a href="<?php echo Url::to('/')?>"><?php echo \Yii::t('common', 'return to dashboard');?></a> <?php echo \Yii::t('common', 'or try using the search form');?>.
          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
