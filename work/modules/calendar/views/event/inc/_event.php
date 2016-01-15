<?php 
use common\models\work\Remind; 
use yii\helpers\Html;
use common\models\work\Calendar;
use common\models\work\Event;
?>
<div class="tab-pane active" id="{{contentBaseId}}-1">
<div class="accsection">
				<div class="topwrap">
					<div class="row">
						<div class="container">
							<div class='col-md-3'>
										 <?= $form->field($event, 'start_datetime',
										 		[ 'template' => '
										 				{label}
										 				<div class="form-group">
										 					<div class="input-group date" id="datetimepicker_start">
										 						{input}
										 						<span class="input-group-addon"> 
										 							<span class="glyphicon glyphicon-calendar"></span>
																</span>
										 					</div>
										 				{error}{hint}
										 				</div>'
												]
										 	) ?>
										
							</div>
							<div class='col-md-3'>
										 <?= $form->field($event, 'end_datetime',
										 		[ 'template' => '
										 				{label}
										 				<div class="form-group">
										 					<div class="input-group date" id="datetimepicker_end">
										 						{input}
										 						<span class="input-group-addon"> 
										 							<span class="glyphicon glyphicon-calendar"></span>
																</span>
										 					</div>
										 				{error}{hint}
										 				</div>'
												]
										 ) ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-3'>
    							<?= $form->field($model_remind, 'owner_id')->checkbox() ?>
							</div>
	
							<div class='col-md-3'>
								<?= $form->field($model_remind, 'minute_before')->dropDownList(Remind::getTimeRemind(), ['options'=>['30' => ['Selected'=>true]]], ['prompt'=>  Yii::t('app', 'Please choose your type')])->label(false); ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<?= $form->field($event, 'name')->textInput(['maxlength' => true]) ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<?= $form->field($event, 'address')->textInput(['maxlength' => true]) ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<?= $form->field($event, 'description')->textarea(['rows' => 6]) ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Files');?></h4>
								<div class="form-group">
								<input class="file" type="file" multiple data-preview-file-type="any" data-upload-url="#">
								</div>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Calendar');?></h4>
								<div class="form-group">
									<?= $form->field($model_calendar, 'name')->dropDownList(Event::getCalendarOption(), ['options'=>['30' => ['Selected'=>true]]], ['prompt'=>  Yii::t('app', 'Please choose your type')])->label(false); ?>
								</div>
								
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
    							<?= $form->field($event, 'is_public')->checkbox() ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6 form-inline align_right'>
								<p>
								  <?= Html::submitButton(Yii::t('app', 'Submit'), ['class'=> 'btn btn-primary']) ;?>
								  <?= Html::submitButton(Yii::t('app', 'Close'), ['class'=> 'btn btn-large']) ;?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>