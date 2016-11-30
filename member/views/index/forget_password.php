<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Request password reset';
?>
<div class="container">
    <div class="forget-password">
        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3>Tìm tài khoản của bạn</h3>
                    <span>
                        Chúng tôi có thể giúp bạn đặt lại mật khẩu của mình bằng địa chỉ email được liên kết với tài khoản của bạn.
                    </span>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail" class="col-xs-2 control-label"><i class="fa fa-envelope"></i></label>
                        <div class="col-xs-7 no-padding">
                            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn-flat']) ?>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
