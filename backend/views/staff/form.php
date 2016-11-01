<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Staff;
use common\models\Job;
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            <?php if ($model->isNewRecord) { ?>
                Add staff
            <?php } else { ?>
                Update Staff
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
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'phone_no')->textInput() ?>
        <?= $form->field($model, 'address')->textInput() ?>
        <?=
            $form->field($model, 'job_id')->dropdownList(
                    Job::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => 'Select job']
            );
        ?>
    </div>

    <div class="box-footer">
        <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
</div>
