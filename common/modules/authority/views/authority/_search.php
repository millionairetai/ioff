<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\authority\models\ActionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="action-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'controller_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'is_display_menu')->checkbox() ?>

    <?php // echo $form->field($model, 'datetime_created') ?>

    <?php // echo $form->field($model, 'lastup_datetime') ?>

    <?php // echo $form->field($model, 'lastup_employee_id') ?>

    <?php // echo $form->field($model, 'disabled')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('authority', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('authority', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
