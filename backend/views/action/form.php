<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Controller;
use common\models\Language;
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            <?php if ($model->isNewRecord) { ?>
                Create new functionality
            <?php } else { ?>
                Update functionality
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
        <?=
            $form->field($model, 'controller_id')->dropdownList(
                    Controller::find()->select(['column_name', 'id'])->indexBy('id')->column(), ['prompt' => 'Select controller']
            );
        ?>
        <?= $form->field($model, 'column_name')->textInput() ?>
        <?= $form->field($model, 'url')->textInput() ?>
        <?= $form->field($model, 'translated_text')->textInput() ?>
        <?= $form->field($model, 'is_check')->checkBox() ?>
        <?= $form->field($model, 'is_display_menu')->checkBox() ?>
        <?=
            $form->field($model, 'description')->textarea(
                    [
                        'id' => 'editor1',
                        'class' => 'textarea',
                        'style' => 'width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px'
            ]);
        ?>
                <?=
            $form->field($model, 'language_id')->dropdownList(
                    Language::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => 'Select language']
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
