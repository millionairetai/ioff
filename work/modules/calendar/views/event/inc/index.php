<?php
/* @var $this yii\web\View */
/* @var $model common\models\calendar\event */

$this->title = 'Create Event';
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Events',
		'url' => [ 
				'index' 
		] 
];

$this->params ['breadcrumbs'] [] = $this->title;
?>

<div ng-app="calendarDemoApp" class="event-create">
	<div role="main">
		<section id="directives-calendar" ng-controller="CalendarCtrl">
			<div class="well">
				<div class="row-fluid">
					<div class="span12">
						<tabset>
							<div class="alert-success calAlert" ng-show="alertMessage != undefined && alertMessage != ''">
								<h4>{{alertMessage}}</h4>
							</div>

							<div class="row">
								<div class="col-xs-12 col-md-8">
									<div class="btn-toolbar">
										<div class="btn-group">
											<button class="btn btn-success" ng-click="changeView('month', 'myCalendar1')"><?= Yii::t('app', 'Month');?></button>
											<button class="btn btn-success" ng-click="changeView('agendaWeek', 'myCalendar1')"><?= Yii::t('app', 'Week');?></button>
											<button class="btn btn-success" ng-click="changeView('agendaDay', 'myCalendar1')"><?= Yii::t('app', 'Day');?></button>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-md-4">
									<div ng-controller="MainCtrl" class="container">
										<button ng-click="toggleModal()" class="btn btn-primary"><?= Yii::t('app', 'Add Event');?></button>
										<?= $this->render('inc/_popup', ['event' => $model_event, 'model_remind' => $model_remind, 'inviation' => $model_inviation, 'model_department' => $model_department]) ?>
									</div>
								</div>
							</div>
							<div class="calendar" ng-model="eventSources" calendar="myCalendar1" ui-calendar="uiConfig.calendar"></div>
						</tabset>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>