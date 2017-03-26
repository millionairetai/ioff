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
                    $objects[] = [
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

        return $this->sendResponse($this->_error, '', ['upcomingEvents' => $objects]);
    }

    // Get events search global
    public function actionGetSearchGlobalEvents() {
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $searchText = \Yii::$app->request->get('searchText');
        $collection = [];

        $result = Event::getEventByName($this->_companyId, \Yii::$app->user->getId(), $searchText, $currentPage, $itemPerPage);
        if (!empty($result['event'])) {
            foreach ($result['event'] as $value) {
                $collection[] = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'start' => date('Y-m-d H:i:s', $value['start_datetime']),
                    'end' => date('Y-m-d H:i:s', $value['end_datetime']),
                    'color' => "#" . $value['color'],
                    'is_all_day' => $value['is_all_day'],
                    'description_parse' => $value['description_parse'],
                ];
            }
        }

        $objects = [];
        $objects['events'] = $collection;
        $objects['totalCount'] = !empty($result['totalRow'][0]['total_row']) ? $result['totalRow'][0]['total_row'] : 0;
        return $this->sendResponse(false, "", $objects);
    }

    // Get events search global suggestion
    public function actionGetSearchGlobalSuggestion() {
        $collection = [];
        $searchText = \Yii::$app->request->post('val');
        $result = Event::getEventByName($this->_companyId, \Yii::$app->user->getId(), $searchText, 1, 10);
        foreach ($result['event'] as $task) {
            $collection[] = $task['name'];
        }

        return $this->sendResponse(false, '', ['collection' => $collection]);
    }
}
