<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
			<div class="tab-pane active" id="{{contentBaseId}}-1">
				<div class="container">
					<div class="row">
				    	<div class="col-sm-3">
				      		<h3>Column 1</h3>
				      		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
				      		<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
				    	</div>
					    <div class="col-sm-3">
					    		<h3>Column 2</h3>
					      		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
					      	<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
					    </div>
				  	</div>
				</div>
			</div>
			
			<div class="tab-pane" id="{{contentBaseId}}-2">
				<div class="accsection">
			<div class="topwrap">
				<div class="row">
					<div class="container">
						<div class="row">
					    	<div class="col-sm-3">
					      		<h3><?= Yii::t('app', 'Start date and time');?></h3>
					      		<p>
					      			<?= $form->field($model, 'calendar_id')->textInput() ?>
					      			<?= $form->field($model, 'calendar_id')->textInput() ?>
					      		</p>
					    	</div>
						    <div class="col-sm-3">
						    	<h3><?= Yii::t('app', 'Start date and time');?></h3>
						    	<p><input type="text"><input type="text" class="input_time"></p>
						    </div>
					  	</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
</modal>
