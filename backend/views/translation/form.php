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
                Add translation 
            <?php } else { ?>
                Update translation 
            <?php } ?>
        </h3>
    </div><!-- /.box-header -->
    <?php
    $form = ActiveForm::begin([
                'id' => 'translation-form',
                'options' => [
                    'class' => '',
                    'role' => 'form'
                ],
            ])
    ?>

    <div class="box-body">
        <?=$form->field($model, 'owner_table')->dropdownList($ownerTable, ['prompt' => '--']);?>
        <?=$form->field($model, 'owner_id')->dropdownList($ownerIds, ['prompt' => '--']);?>
        <?php
        foreach ($language as $key => $val) {
            echo $val . "<br />";
            echo $form->field($model, "translated_text[{$key}]")->textInput();
        }
        ?>
    </div>

    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>


   