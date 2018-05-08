<?php

use yii\widgets\ActiveForm;
?>
<div class="login-box">
    <div class="login-box-body">
        <div class="login-logo">
            <b>I</b>OFFICEZ
        </div><!-- /.login-logo -->
        <?php $form = ActiveForm::begin(); ?>
         <small>
            <div>
                <?php echo $form->errorSummary($model, ['header' => '','class' => 'alert text-left alert-danger ']) ?>
            </div>
        </small> 
        <div class="form-group has-feedback">
            <?php echo $form->field($model, 'username', ['template' => '{input}'])->textInput(array('placeholder' => \Yii::t('common', 'Username'))); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?php echo $form->field($model, 'password', ['template' => '{input}'])->passwordInput(array('placeholder' => \Yii::t('common', 'Password'))); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-4 col-xs-offset-8">
                <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo \Yii::t('common', 'Login'); ?></button>
            </div><!-- /.col -->
        </div>
        <?php ActiveForm::end(); ?>

        <div class="text-center" style="margin: 10px 0px 0px 0px;"><a href="#" ><?php echo \Yii::t('common', 'Forgot password'); ?></a></div><br>
       
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->