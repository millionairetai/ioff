<?php

use yii\widgets\ActiveForm;
?>
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
            <?php $form = ActiveForm::begin(); ?>
                <div class="form-group has-feedback">
                    <?php echo $form->field($model, 'username', ['template' => '{input}'])->textInput(array('placeholder' => 'User name')); ?>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $form->field($model, 'password', ['template' => '{input}'])->passwordInput(array('placeholder' => 'Password')); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">  Login</button>
                    </div><!-- /.col -->
                </div>
            <?php ActiveForm::end(); ?>

        <div class="text-center" style="margin: 10px 0px 0px 0px;"><a href="#" >I forgot my password</a></div><br>
        <small>
            <div>
                    <?php echo $form->errorSummary($model, ['class' => 'alert text-left alert-danger ']) ?>
            </div>
        </small> 
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->