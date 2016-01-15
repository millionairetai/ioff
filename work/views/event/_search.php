<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model work\modules\demo\models\EventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'calendar_id') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'description_parse') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'start_datetime') ?>

    <?php // echo $form->field($model, 'end_datetime') ?>

    <?php // echo $form->field($model, 'is_public')->checkbox() ?>

    <?php // echo $form->field($model, 'datetime_created') ?>

    <?php // echo $form->field($model, 'lastup_datetime') ?>

    <?php // echo $form->field($model, 'lastup_employee_id') ?>

    <?php // echo $form->field($model, 'disabled')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
