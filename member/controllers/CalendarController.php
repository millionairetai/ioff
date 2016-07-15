<?php

namespace member\controllers;

use common\models\Calendar;
use common\models\Event;
use common\models\Invitation;
use common\models\File;
use common\models\Activity;
use common\models\EventConfirmation;
use common\models\Notification;
use common\models\Remind;
use common\models\Employee;
use common\models\Sms;
use common\models\EmployeeActivity;
use Yii;

class CalendarController extends ApiController {

    // List all calendar
    public function actionIndex() {
        $objects = [];
        if ($calendars = Calendar::getAllCalendar($this->_companyId, \Yii::$app->user->identity->id)) {
            foreach ($calendars as $calendar) {
                $objects[] = [
                    'id' => (int) $calendar['calendar_id'],
                    'name' => $calendar['name'],
                    'count' => (int) $calendar['number_event']
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

    // Get events
    public function actionEvents() {
        $objects = [];
        $start = \Yii::$app->request->post('start');
        $end = \Yii::$app->request->post('end');
        $calendars = \Yii::$app->request->post('calendars', []);

        if ($data = Event::getEvents($calendars, $this->_companyId, \Yii::$app->user->getId(), $start, $end)) {
            foreach ($data as $value) {
                $objects[] = [
                    'title' => $value['name'],
                    'start' => date('Y-m-d H:i:s', $value['start_datetime']),
                    'end' => date('Y-m-d H:i:s', $value['end_datetime']),
                    'color' => "#" . $value['color']
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

    // Add event
    public function actionAddEvent() {
        $objects = [];
        $dataPost = [];

        $eventJson = \Yii::$app->request->post('event', '');
        if (strlen($eventJson)) {
            $dataPost = json_decode($eventJson, true);
        }

        $transaction = \Yii::$app->db->beginTransaction();

        //create object and validate data
        try {
            $ob = new Event();
            $ob->attributes = $dataPost;
            $ob->employee_id = Yii::$app->user->getId();
            $ob->description_parse = strip_tags($ob->description);
            $ob->start_datetime = $ob->start_datetime ? strtotime($ob->start_datetime) : null;
            $ob->end_datetime = $ob->end_datetime ? strtotime($ob->end_datetime) : null;

            if (!$ob->save()) {
                $this->_message = $this->parserMessage($ob->getErrors());
                $this->_error = true;
                throw new \Exception($this->_message);
            }
            
            //add department
            if (!empty($dataPost['departments'])) {
                $projectParticpants = [];
                foreach ($dataPost['departments'] as $value) {
                    $projectParticpants[] = [$ob->id, $value, Invitation::TABLE_DEPARTMENT];
                }

                if (!Yii::$app->db->createCommand()->batchInsert(
                                Invitation::tableName(), ['event_id', 'owner_id', 'owner_table'], $projectParticpants)->execute()) {
                    throw new \Exception('batchInsert for departments to table invitation fail');
                }
            }

            //add member
            if (!empty($dataPost['members'])) {
                $projectParticpants = [];
                foreach ($dataPost['members'] as $item) {
                    $projectParticpants[] = [$ob->id, $item['id'], Invitation::TABLE_EMPLOYEE];
                }

                if (!Yii::$app->db->createCommand()->batchInsert(
                                Invitation::tableName(), ['event_id', 'owner_id', 'owner_table'], $projectParticpants)->execute()) {
                    throw new \Exception('batchInsert for employees to table invitation fail');
                }
            }

            //move file
            File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $ob->id, File::TABLE_EVENT);

            //activity
            $activity = new Activity();
            $activity->owner_id = $ob->id;
            $activity->owner_table = Activity::TABLE_EVENT;
            $activity->parent_employee_id = 0;
            $activity->employee_id = \Yii::$app->user->getId();
            $activity->type = "create_event";
            $activity->content = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name;

            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }

            //Employee activity
            $employeeActivity = EmployeeActivity::find()->andCompanyId()->andWhere(['employee_id' => \Yii::$app->user->getId()])->one();
            if (!$employeeActivity) {
                $employeeActivity = new EmployeeActivity();
                $employeeActivity->employee_id = \Yii::$app->user->getId();
                $employeeActivity->activity_calendar = $employeeActivity->activity_total = 0;
            }

            $employeeActivity->activity_calendar += 1;
            $employeeActivity->activity_total += 1;
            if (!$employeeActivity->save()) {
                throw new \Exception('Save record to table EmployeeActivity fail');
            }

            //get all employ
            $arrayEmployees = [];
            $isQuery = false;
            $query = Employee::find()->andCompanyId();

            if (!empty($dataPost['members']) && !empty($dataPost['departments'])) {
                $isQuery = true;
                $idEmployees = [];

                foreach ($dataPost['members'] as $item) {
                    $idEmployees[] = $item['id'];
                }

                $query->andWhere('id in (' . implode(',', $idEmployees) . ') or department_id in (' . implode(',', $dataPost['departments']) . ')');
            } elseif (!empty($dataPost['members'])) {
                $isQuery = true;
                $idEmployees = [];

                foreach ($dataPost['members'] as $item) {
                    $idEmployees[] = $item['id'];
                }

                $query->andWhere(['id' => $idEmployees]);
            } elseif (!empty($dataPost['departments'])) {
                $isQuery = true;
                $query->andWhere(['department_id' => $dataPost['departments']]);
            }

            if ($isQuery) {
                $content = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name;
                $arrayEmployees = $query->all();

                $dataSend = [
                    '{creator name}' => \Yii::$app->user->identity->firstname,
                    '{event name}' => $ob->name
                ];

                $themeEmail = \common\models\EmailTemplate::getThemeCreateEvent();
                $themeSms = \common\models\SmsTemplate::getThemeCreateEvent();

                $notifications = [];
                $eventConfirmations = [];
                $sms = [];
                $remind = [];

                foreach ($arrayEmployees as $item) {
                    //save notification
                    $notifications[] = [$ob->id, Notification::TABLE_EVENT, $item->id, \Yii::$app->user->getId(), "create_event", $content];

                    //event confirmation
                    $eventConfirmations[] = [$ob->id, $item->id, 0];

                    //save sms
                    if ($ob->sms) {
                        $sms[] = [$ob->id, $item->id, \common\models\Sms::TABLE_EVENT, $content, 1, 0];
                    }
                    
                    //remind
                    if (!empty($dataPost['redmind'])) {
                        $remind[] = [$item->id, $ob->id, Remind::TABLE_EVENT, $ob->name, $ob->start_datetime - ($dataPost['redmind'] * 60), $dataPost['redmind'], 0, 0];
                    }
                }

                if (!empty($notifications)) {
                    if (!Yii::$app->db->createCommand()->batchInsert(
                                    Notification::tableName(), ['owner_id', 'owner_table', 'employee_id', 'owner_employee_id', 'type', 'content'], $notifications)->execute()) {
                        throw new \Exception('BatchInsert to notification table fail');
                    }
                }

                if (!empty($eventConfirmations)) {
                    if (!Yii::$app->db->createCommand()->batchInsert(
                                    EventConfirmation::tableName(), ['event_id', 'employee_id', 'confirm_event_id'], $eventConfirmations)->execute()) {
                        throw new \Exception('BatchInsert to event_confirmation table fail');
                    }
                }
                
                if (!empty($remind)) {
                    if (!Yii::$app->db->createCommand()->batchInsert(
                                    Remind::tableName(), ['employee_id', 'owner_id', 'owner_table', 'content', 'remind_datetime', 'minute_before', 'repeated_time', 'is_snoozing'], $remind)->execute()) {
                        throw new \Exception('BatchInsert to remind table fail');
                    }
                }

                if (!empty($sms)) {
                    if (!Yii::$app->db->createCommand()->batchInsert(
                                    Sms::tableName(), ['owner_id', 'employee_id', 'owner_table', 'content', 'is_success', 'fee'], $sms)->execute()) {
                        throw new \Exception('BatchInsert to sms table fail');
                    }
                }

                //send email and sms
                foreach ($arrayEmployees as $item) {
                    $item->sendMail($dataSend, $themeEmail);
                    if ($ob->sms) {
                        $item->sendSms($dataSend, $themeSms);
                    }
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $this->_message = $e->getMessage();

            if (!$this->_error) {
                $this->_error = true;
                $this->_message = \Yii::t('member', 'error_system');
            }

            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }

        return $this->sendResponse($this->_error, $this->_message, $objects);
    }

    /**
     * 
     */
    public function actionLanguage() {
        $error = false;
        $message = "";
        $objects = ['language' => \Yii::$app->language];
        return $this->sendResponse($error, $message, $objects);
    }

}
