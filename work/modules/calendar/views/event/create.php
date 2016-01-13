<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\calendar\event */

$this->title = 'Create Event';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'start_datetime') ?>
        <?= $form->field($model, 'end_datetime') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'description') ?>
        
        <?= Html::submitButton('Login') ?>
    <?php ActiveForm::end(); ?>
    
    <div role="main">
    <div class="container">
        <section id="directives-calendar" ng-controller="CalendarCtrl">
            <div class="page-header">
                <h1>UI-Calendar</h1>
            </div>
            <div class="well">
                <div class="row-fluid">
                <!-- 
                    <div class="span4">
                        
                        <h3>What?</h3>

                        <p>Attach Angular objects to a calendar.</p>
                        <p>Show the data binding between two differnet calendars using the same event sources.</p>

                        <h3>Why?</h3>

                        <p>Why Not?</p>
                         
                        <div class="btn-group calTools">
                        
                          <button class="btn" ng-click="changeLang()">
                            {{changeTo}}
                          </button>              
                          <button class="btn" ng-click="addRemoveEventSource(eventSources,eventSource)">
                            Toggle Source
                          </button>
                       
                          <button type="button" class="btn btn-primary" ng-click="addEvent()">
                            Add Event
                          </button>
                           
                        </div>
                        
                        
                        <ul class="unstyled">
                            <li ng-repeat="e in events">
                                <div class="alert alert-info">
                                    <a class="close" ng-click="remove($index)"><i class="icon-remove"></i></a>
                                    <b> <input ng-model="e.title"></b> 
                                    {{e.start | date:"MMM dd"}} - {{e.end | date:"MMM dd"}}
                                </div>
                            </li>
                        </ul>
                         
                    </div>
                    -->
                    <div class="span12">
                        <tabset>
                           <div class="alert-success calAlert" ng-show="alertMessage != undefined && alertMessage != ''">
                                <h4>{{alertMessage}}</h4>
                              </div>
                              
                              <div class="row">
                                <div class="col-xs-12 col-md-8">
                                <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button class="btn btn-success" ng-click="changeView('month', 'myCalendar1')">Tháng</button>
                                    <button class="btn btn-success" ng-click="changeView('agendaWeek', 'myCalendar1')">Tuần</button>
                                    <button class="btn btn-success" ng-click="changeView('agendaDay', 'myCalendar1')">Ngày</button>
                                </div>
                              </div>
                                </div>
                                <div class="col-xs-6 col-md-4">
                                <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" ng-click="addEvent()">
                            Add Event
                          </button>
                                </div>
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

</div>

