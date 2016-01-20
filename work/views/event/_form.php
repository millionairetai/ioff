<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\work\event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'calendar_id')->textInput() ?>

    <?= $form->field($model, 'employee_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description_parse')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_datetime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_datetime')->textInput() ?>

    <?= $form->field($model, 'is_public')->checkbox() ?>

    <?= $form->field($model, 'datetime_created')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastup_datetime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastup_employee_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'disabled')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
