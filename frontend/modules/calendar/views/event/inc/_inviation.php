<?php 
use common\models\work\Event;

use kartik\widgets\ActiveForm;
?>

<div class="tab-pane" id="{{contentBaseId}}-2">
			<div class="accsection">
				<div class="topwrap">
					<div class="row">
						<div class="container">
							<h4><?= Yii::t('app', 'Department');?></h4>
							<div class='col-md-6'>
								<?= $form->field($model_department, 'id', ['template' => "{label}\n{input}\n{hint}\n{error}"])->checkboxList(Event::getDepartmentNameCheckBox())->label(false); ?>
							</div>
						</div>

						<div class="container">
							<div class='col-md-6'>
								<?= $form->field($model_department, 'id')->checkboxList(Event::getDepartmentNameCheckBox())->label(false); ?>
							</div>
						</div>

						<div class="container">
							<div class='col-md-6'>
								<p>
								  <button class="btn btn-large btn-primary" type="button">Large button</button>
								  <button class="btn btn-large" type="button">Large button</button>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>