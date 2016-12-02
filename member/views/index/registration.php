<?php

use yii\widgets\ActiveForm;
use common\widgets\Alert;

$this->title = Yii::t('member', 'Registration employee');
?>
<div class="container">
    <div class="row">
        <div class="register-box">
            <?php $form = ActiveForm::begin(['id' => 'registration_form']); ?>
            <h2><?= Yii::t('member', 'Confirming registration on') ?> iofficez</h2>
            <hr/>
            <small>
                <div>
                    <?= $form->errorSummary($registration, ['header' => '', 'class' => 'alert text-left alert-danger ']) ?>
                </div>
            </small> 
            <?= Alert::widget() ?>
            <p><b><?= Yii::t('common', 'Email') ?></b>: <?= $registration->email ?></p>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <?php echo $form->field($registration, 'firstName', ['template' => '{input}'])->textInput(['placeholder' => \Yii::t('common', 'First name'), 'tabindex' => 1]); ?>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <?php echo $form->field($registration, 'lastName', ['template' => '{input}'])->textInput(['placeholder' => \Yii::t('common', 'Last name'), 'tabindex' => 2]); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->field($registration, 'password', ['template' => '{input}'])->passwordInput(['placeholder' => \Yii::t('common', 'Password'), 'tabindex' => 3]); ?>
            </div>
            <div class="form-group">
                <?php echo $form->field($registration, 'rePassword', ['template' => '{input}'])->passwordInput(['placeholder' => \Yii::t('common', 'Re-Password'), 'tabindex' => 4]); ?>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label class="">
                            <div aria-checked="false" aria-disabled="false">
                                <?php echo $form->field($registration, 'agree', ['template' => '{input}'])->label(false)->checkbox(); ?>
                            </div> 
                            <a href="<?= Yii::$app->params['frontendDomain'] ?>/index/term"><?= Yii::t('member', 'to the terms') ?></a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat"><?= Yii::t('common', 'Register'); ?></button>
                </div>
                <!-- /.col -->
            </div>
            <a href="login" class="text-center"><?= Yii::t('common', 'I already have a membership') ?></a>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
