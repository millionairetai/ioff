<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;

$this->title = Yii::t('member', 'request password reset');
?>
<div class="container">
    <div class="forget-password">
        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3><?= Yii::t('member', 'retrieve password') ?></h3>
                <span>
                    <?= Yii::t('member', 'label request password reset') ?>
                </span>
            </div>
            <div class="box-body">
                <?php if ($requestSuccess): ?>
                <p>
                    <?= sprintf(Yii::t('member', 'annouce sent password reset request'), $model->email) ?>
                </p>
                <p>
                    <?= Yii::t('member', 'note when view email') ?>
                </p>
                <div class="Section-footer">
                    <a href="/index/forgot-password">
                       <?= Yii::t('member', 'I didnot receive the email') ?>
                    </a>
                </div>
                <?php else : ?>
                <div class="form-group">
                    <label for="inputEmail" class="col-xs-2 control-label"><i class="fa fa-envelope"></i></label>
                    <div class="col-xs-7 no-padding">
                        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="box-footer">
                <?php if (!$requestSuccess): ?>
                <div class="pull-right">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn-flat']) ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
