<?php

use yii\widgets\ActiveForm;
?>
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <div class="login-logo">
            <b>CENTER</b>OFFICE
        </div><!-- /.login-logo -->
        <!--<br />-->
            <!--<p class="login-box-msg">Sign in to start your session</p>-->
        <?php $form = ActiveForm::begin(); ?>
        <small>
            <div>
                <?php echo $form->errorSummary($model, ['header' => '','class' => 'alert text-left alert-danger '],'') ?>
            </div>
        </small>
        <div class="form-group has-feedback">
            <?php echo $form->field($model, 'email', ['template' => '{input}'])->textInput(array('placeholder' => 'Email')); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?php echo $form->field($model, 'password', ['template' => '{input}'])->passwordInput(array('placeholder' => \Yii::t('common', 'Password'))); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
            </div>
            <!-- /.col -->
        </div>
        <?php ActiveForm::end(); ?>
        <div class="text-center" style="margin: 10px 0px 0px 0px;"><a href="#" >I forgot my password</a></div>
         
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
