<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="container">
    <div class="box reset-password">
        <div class="box-header with-border">
            <h3 class="text-center box-title">Thay đổi mật khẩu </h3>
        </div>
        <div class="box-body">
            <div class="col-md-4">
                <div class="box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?= $model->employee->image ?>" alt="User profile picture">
                    <h3 class="profile-username text-center"><?= $model->employee->fullname ?></h3>
                </div>
            </div>
            <div class="col-md-8">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                    <div class="form-group has-feedback">
                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => "Mật khẩu mới"])->label(false) ?>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <?= $form->field($model, 'rePassword')->passwordInput(['autofocus' => true, 'placeholder' => "Nhập lại mật khẩu mới"])->label(false) ?>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group">
                        <div class="pull-right">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-flat']) ?>
<!--                            <button type="submit" class="btn btn-primary btn-flat">Thay đổi</button>-->
                        </div>
                    </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
