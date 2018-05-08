<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use common\models\Language;
use common\models\PlanType;
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            <?php if ($model->isNewRecord) {
                echo Yii::t('backend', 'Add company'); ?>
            <?php } else {
                echo Yii::t('backend', 'Update company'); ?>

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
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'phone_no')->textInput() ?>
        <?= $form->field($model, 'address')->textInput() ?>
        <?= $form->field($model, 'domain')->textInput() ?>
        <?= $form->field($model, 'description_title')->textInput(); ?>
        <?= $form->field($model, 'description')->textarea(); ?>        
        <?= $form->field($model, 'total_storage')->textInput() ?>
        <?= $form->field($model, 'total_employee')->textInput() ?>
        <?=
            $form->field($model, 'plan_type_id')->dropdownList(
                    PlanType::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => Yii::t('common', 'Select')]
            );
        ?>
        <?=
            $form->field($model, 'status_id')->dropdownList(
                    Status::find()->select(['name', 'id'])->where(['owner_table'=>'company'])->indexBy('id')->column(), ['prompt' => Yii::t('common', 'Select')]
            );
        ?>
        <?=
        $form->field($model, 'language_id')->dropdownList(
                Language::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => Yii::t('common', 'Select')]
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
