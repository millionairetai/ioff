<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<?=
$form->field($model, 'username', ['inputOptions' => [
        'placeholder' => $model->getAttributeLabel('Username'),
    ], 'inputTemplate' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>'])->label(false)
?>

<?= $form->field($model, 'password', ['inputOptions' => [
        'placeholder' => $model->getAttributeLabel('Password')], 'inputTemplate' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>'])->passwordInput()->label(false)
?>

<?= $form->field($model, 'rememberMe')->checkbox() ?>

<div class="form-group">
<?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>
