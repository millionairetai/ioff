<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Staff;
use common\models\Job;
use common\models\Authority;
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            <?php if ($model->isNewRecord) {  echo Yii::t('backend', 'Add staff');?>
            <?php } else { echo Yii::t('backend', 'Update staff'); ?>
                
            <?php } ?>
        </h3>
    </div><!-- /.box-header -->
    <?php
    $form = ActiveForm::begin([
                'id' => 'health-form',
                'options' => [
                    'class' => '',
                    'role' => 'form'
                ],
            ])
    ?>

    <div class="box-body">
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
         <?= $form->field($model, 'phone_no')->textInput() ?>
         <?= $form->field($model, 'address')->textInput() ?>
        <?php if ($model->isNewRecord) { ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 're_password')->passwordInput() ?>
        <?php } ?>
        <?=
            $form->field($model, 'job_id')->dropdownList(
                    Job::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => Yii::t('common', 'Select')]
            );
        ?>
        <?=
            $form->field($model, 'authority_id')->dropdownList(
                    Authority::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => Yii::t('common', 'Select')]
            );
        ?>
    </div>

    <div class="box-footer">
        <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
</div>
