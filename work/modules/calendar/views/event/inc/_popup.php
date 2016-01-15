<?php
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\calendar\event */
/* @var $form yii\widgets\ActiveForm */
?>

<modal title="<?= Yii::t('app', 'TITLE FORM');?>" visible="showModal" style="display: none;">
	<?php $form = ActiveForm::begin(); ?>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#{{contentBaseId}}-1" data-toggle="tab"><?= Yii::t('app', 'Event');?></a></li>
		<li><a href="#{{contentBaseId}}-2" data-toggle="tab"><?= Yii::t('app', 'Inviation');?></a></li>
	</ul>
	<div class="tab-content">
	<br/>
		<?= $this->render('_event', ['form' => $form, 'event' => $event, 'model_remind' => $model_remind, 'model_calendar' => $model_calendar]) ?>
		<?= $this->render('_inviation', ['form' => $form, 'inviation' => $inviation, 'model_department' => $model_department]) ?>
	</div>
	<?php ActiveForm::end(); ?>
</modal>
