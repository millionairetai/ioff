<?php

namespace member\controllers;

use Yii;
use common\models\Project;
use common\models\EventPost;
use common\models\Calendar;
use common\models\Event;
use common\models\Invitation;
use common\models\Invitee;
use common\models\File;
use common\models\Activity;
use common\models\Remind;
use common\models\Employee;
use common\models\Sms;
use common\models\EmployeeActivity;
use common\models\EventConfirmationType;
use common\models\EventConfirmation;
use common\models\Notification;

class EventController extends ApiController {

    // Get upcoming event
    public function actionGetUpcomingEvent() {
        $upcomingEvents = [];
        $objects = [];
        try {
            if ($upcomingEvents = Event::getUpcomingEventByEmployeeId(Yii::$app->user->identity->id)) {
                //Check condition to get info.
                foreach ($upcomingEvents as $upcomingEvent) {
                    $objects[] =[
                        'name' => $upcomingEvent['name'],
                        'start_datetime' => Yii::$app->formatter->asDatetime($upcomingEvent['start_datetime']),
                    ];
                }
                
               return $this->sendResponse($this->_error, '', ['upcomingEvents' => $objects]);
            }
        } catch (\Exception $ex) {
            $this->_error = true;
            return $this->sendResponse($this->_error, $this->_message, []);
        }

        return $this->sendResponse($this->_error, '', ['upcomingEvents' => $objects] );
    }

}
