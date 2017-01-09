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
        <?= $form->field($model, 'oldPassword')->passwordInput() ?>
        <?= $form->field($model, 'newPassword')->passwordInput() ?>
        <?= $form->field($model, 'rePassword')->passwordInput() ?>
    </div>

    <div class="box-footer">
        <div class="form-group">
        <?= Html::submitButton('Đổi mật khẩu', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
</div>
