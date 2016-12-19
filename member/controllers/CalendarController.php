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

class CalendarController extends ApiController {

    // List all calendar
    public function actionIndex() {
        $objects = [];
        if ($calendars = Calendar::getAllCalendar($this->_companyId, \Yii::$app->user->identity->id)) {
            foreach ($calendars as $calendar) {
                $objects[] = [
                    'id' => (int) $calendar['calendar_id'],
                    'name' => $calendar['name'],
                    'description' => $calendar['description'],
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
                    'id' => $value['id'],
                    'title' => $value['name'],
                    'start' => date('Y-m-d H:i:s', $value['start_datetime']),
                    'end' => date('Y-m-d H:i:s', $value['end_datetime']),
                    'color' => "#" . $value['color'],
                    'is_all_day' => $value['is_all_day'],
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
            $activity->type = Activity::TYPE_CREATE_EVENT;
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
                                    EventConfirmation::tableName(), ['event_id', 'employee_id', 'event_confirmation_type_id'], $eventConfirmations)->execute()) {
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
     * Edit vent
     * @throws \Exception
     */
    public function actionEditEvent() {
        $objects = [];
        $dataPost = [];
        $eventJson = \Yii::$app->request->post('event', '');
        if (strlen($eventJson)) {
            $dataPost = json_decode($eventJson, true);
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //Check if get event is null value.
            if (!$ob = Event::getById($dataPost['id'])) {
                throw new \Exception('Get Event info fail');
            }

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

            $mergeDataDeparmentAndEmployee = $this->_mergeDataDeparmentAndEmployee($dataPost);
            //update table invitation
            $this->_updataInvitation($dataPost['id'], $mergeDataDeparmentAndEmployee);
            $mergeEmployee = $this->_mergeDataEmployee($dataPost);
            //update table Event_confirmation
            $this->_updataEventConfirmation($dataPost['id'], $mergeEmployee);

            //update table Remind
            $this->_updataRemind($dataPost, $mergeEmployee, $ob);
            //move file
            $dataPost['fileList'] = File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $ob->id, File::TABLE_EVENT);

            //update table activity
            $activity = new Activity();
            $activity->owner_id = $ob->id;
            $activity->owner_table = Activity::TABLE_EVENT;
            $activity->parent_employee_id = 0;
            $activity->employee_id = \Yii::$app->user->getId();
            $activity->type = Activity::TYPE_EDIT_EVENT;
            $activity->content = Activity::makeContent(\Yii::t('common', 'edited'), $ob->name);
            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }

            //update table Notification
            if (!empty($mergeEmployee['employees'])) {
                //save sms
                $dataInsertSms = $dataInsertNotification = [];
                foreach ($mergeEmployee['employees'] AS $key => $val) {
                    $dataInsertNotification[] = [
                        'owner_id' => $ob->id,
                        'owner_table' => Event::tableName(),
                        'employee_id' => $val,
                        'type' => Activity::TYPE_EDIT_EVENT,
                        'content' => Notification::makeContent(\Yii::t('common', 'edited'), $ob->name),
                        'owner_employee_id' => 0
                    ];

                    $dataInsertInvitee[] = [
                        'event_id' => $ob->id,
                        'employee_id' => $val,
                    ];

                    if ($ob->sms) {
                        $dataInsertSms[] = [
                            'owner_id' => $ob->id,
                            'employee_id' => $val,
                            'owner_table' => Event::tableName(),
                            'content' => Sms::makeContent(\Yii::t('common', 'edited'), $ob->name),
                            'is_success' => true,
                            'fee' => 0,
                            'agency_gateway' => 'esms'
                        ];
                    }
                }

                Invitee::batchInsert($dataInsertInvitee);
                Notification::batchInsert($dataInsertNotification);
                Sms::batchInsert($dataInsertSms);
            }

            //Write log history for editing this project.
            $dataPost['employeeMegre'] = $mergeDataDeparmentAndEmployee;
            if (($eventHistory = $this->_makeEventHistory($dataPost)) && !empty($eventHistory)) {
                //insert project_post table:
                $eventPost = new EventPost();
                $eventPost->event_id = $ob->id;
                $eventPost->company_id = $this->_companyId;
                $eventPost->employee_id = \Yii::$app->user->getId();
                $eventPost->parent_employee_id = 0;
                $eventPost->parent_id = 0;
                $eventPost->content = $eventHistory;
                $eventPost->content_parse = $eventHistory;
                $eventPost->is_log_history = true;
                if (!$eventPost->save()) {
                    throw new \Exception('Save record to table event_post fail');
                }
            }

            $themeEmail = \common\models\EmailTemplate::getThemeEditEvent();
            $themeSms = \common\models\SmsTemplate::getThemeEditEvent();
            //send email and sms
//            if (!empty($mergeEmployee['employees']) && ($ob->sms)) {
            if (!empty($mergeEmployee['employees'])) {
                $dataSend = [
                    '{creator name}' => \Yii::$app->user->identity->fullname,
                    '{event name}' => $ob->name
                ];
                
                $employees = new Employee();
                foreach ($mergeEmployee['employees'] as $item) {
                    $employees->sendMail($dataSend, $themeEmail);
                    if ($ob->sms) {
                        $employees->sendSms($dataSend, $themeSms);
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
     * Fuction display detail of Event by id
     */
    public function actionViewEvent() {
        try {
            if ($eventId = \Yii::$app->request->get('eventId')) {
                if ($event = Event::getInfoEvent($eventId)) {
                    //check authentication to view event
                    if (($event['event']['is_public'] == true) || Employee::isAdmin() || ($event['event']['creator_event_id'] == Yii::$app->user->identity->id)) {
                        return $this->sendResponse(false, "", $event);
                    } else {
                        if (EventConfirmation::isInvited($eventId)) {
                            return $this->sendResponse(false, "", $event);
                        } else {
                            $objects['collection']['error'] = true;
                            return $this->sendResponse(false, \Yii::t('member', "you do not have authoirity for this action"), $objects['collection']);
                        }
                    }
                }
            }

            throw new \Exception(\Yii::t('member', 'Can not get data'));
        } catch (\Exception $e) {
            return $this->sendResponse(true, $e->getMessage(), []);
        }
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

    /**
     * Function update or add info in table project_participant of screen edit project
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _mergeDataEmployee($dataPost = []) {
        if (empty($dataPost)) {
            return false;
        }

        $invitees = [];
        $employeeOld = !empty($dataPost['data_old']['invitations']['departmentAndEmployee']['employeeList']) ? $dataPost['data_old']['invitations']['departmentAndEmployee']['employeeList'] : null;
        if (!empty($dataPost['members'])) {
            foreach ($dataPost['members'] as $val) {
                $invitees[] = $val['id'];
            }
        }
        
        $employeeNew = Employee::getlistByepartmentIdsAndEmployeeIds($dataPost['departments'], $invitees);
        $employeeAttend = isset($dataPost['data_old']['attent']['eventConfirmList']) ? $dataPost['data_old']['attent']['eventConfirmList'] : [];
        $result = [];

        if (!empty($employeeOld) && !empty($employeeNew['employeeList'])) {
            foreach ($employeeOld as $keyEmployessOld => $valEmployeeOld) {
                $result['employeeOld'][$keyEmployessOld] = $valEmployeeOld['id'];
                foreach ($employeeNew['employeeList'] as $keyMemberNew => $valMemberNew) {
                    if (!in_array($valMemberNew['id'], array_values($employeeAttend))) {
                        $result['employeeNew'][$keyMemberNew] = $valMemberNew['id'];
                        $result['employees'][$keyMemberNew] = $valMemberNew['id'];
                    }
                    if ($valEmployeeOld['id'] == $valMemberNew['id']) {
                        unset($employeeOld[$keyEmployessOld]);
                        unset($employeeNew['employeeList'][$keyMemberNew]);
                        unset($result['employeeOld'][$keyEmployessOld]);
                        unset($result['employeeNew'][$keyMemberNew]);
                    }
                }
            }
        } else if (!empty($employeeOld) && empty($employeeNew['employeeList'])) {
            foreach ($employeeOld as $keyEmployessOld => $valEmployeeOld) {
                $result['employeeOld'][$keyEmployessOld] = $valEmployeeOld['id'];
            }
        } else if (empty($employeeOld) && !empty($employeeNew['employeeList'])) {
            foreach ($employeeNew['employeeList'] as $keyMemberNew => $valMemberNew) {
                if (!in_array($valMemberNew['id'], array_values($employeeAttend))) {
                    $result['employeeNew'][$keyMemberNew] = $valMemberNew['id'];
                    $result['employees'][$keyMemberNew] = $valMemberNew['id'];
                }
            }
        }
        return $result;
    }

    /**
     * Function update or add info in table project_participant of screen edit project
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _mergeDataDeparmentAndEmployee($dataPost = []) {
        if (empty($dataPost))
            return false;

        $departmentOld = !empty($dataPost['data_old']['invitations']['department']) ? $dataPost['data_old']['invitations']['department'] : null;
        $departmentNew = !empty($dataPost['departments']) ? $dataPost['departments'] : null;
        if (!empty($departmentNew) && !empty($departmentOld)) {
            foreach ($departmentNew as $key_new => $val_New) {
                foreach ($departmentOld as $key_old => $val_old) {
                    if ($val_New == $key_old) {
                        unset($departmentNew[$key_new]);
                        unset($departmentOld[$key_old]);
                    }
                }
            }
        }

        $employeeOld = !empty($dataPost['data_old']['invitations']['employee']) ? $dataPost['data_old']['invitations']['employee'] : null;
        $employeeNew = !empty($dataPost['members']) ? $dataPost['members'] : null;
        if (!empty($employeeOld) && !empty($employeeNew)) {
            foreach ($employeeOld as $keyEmployessOld => $valEmployeeOld) {
                foreach ($dataPost['members'] as $keyMemberNew => $valMemberNew) {
                    if ($keyEmployessOld == $valMemberNew['id']) {
                        unset($employeeOld[$keyEmployessOld]);
                        unset($employeeNew[$keyMemberNew]);
                    }
                }
            }
        }
        return [
            'departmentOld' => $departmentOld,
            'departmentNew' => $departmentNew,
            'employeeOld' => $employeeOld,
            'employeeNew' => $employeeNew,
        ];
    }

    /**
     * Function update invitee
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataEventConfirmation($event_id = null, $dataMegre = []) {
        if (empty($event_id))
            return false;
        if (empty($dataMegre))
            return true;

        //Delete employee
        if (!empty($dataMegre['employeeOld'])) {
            EventConfirmation::deleteAll([
                'company_id' => $this->_companyId,
                'employee_id' => array_values($dataMegre['employeeOld']),
                'event_id' => $event_id,
            ]);
        }

        //Add new employee
        $eventConfirmation = [];
        if (!empty($dataMegre['employeeNew'])) {
            foreach ($dataMegre['employeeNew'] as $val) {
                $eventConfirmation[] = [
                    'employee_id' => $val,
                    'event_id' => $event_id
                ];
            }
        }

        EventConfirmation::batchInsert($eventConfirmation);
        
        return true;
    }

    /**
     * Function update invitee
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataRemind($dataPost = [], $dataMegre = [], $object = null) {
        if (empty($dataPost['id']))
            return false;
        if (empty($dataMegre))
            return true;
        if (empty($object))
            return true;
        $event_id = $dataPost['id'];

        //check update remind time
        $dataUpdate = [];
        if ($dataPost['redmind'] != $dataPost['data_old']['remind']) {
            if (!\Yii::$app->db->createCommand()->update(Remind::tableName(), [
                        'remind_datetime' => $object->start_datetime - ($dataPost['redmind'] * 60),
                        'minute_before' => isset($dataPost['redmind']) ? $dataPost['redmind'] : 0], ['owner_id' => $event_id, 'company_id' => $this->_companyId, 'owner_table' => Event::tableName()])->execute()
            ) {
                throw new \Exception('Save record to table Project Participant fail');
            }
        }

        //Delete employee
        if (!empty($dataMegre['employeeOld'])) {
            Remind::deleteAll([
                'company_id' => $this->_companyId,
                'employee_id' => array_values($dataMegre['employeeOld']),
                'owner_id' => $event_id,
                'owner_table' => Event::tableName(),
            ]);
        }
        //Add new employee
        $dataInsertInvitation = [];
        if (!empty($dataMegre['employeeNew'])) {
            foreach ($dataMegre['employeeNew'] as $val) {
                $dataInsertInvitation[] = [
                    'employee_id' => $val,
                    'owner_id' => $event_id,
                    'owner_table' => Event::tableName(),
                    'content' => $dataPost['name'],
                    'remind_datetime' => $object->start_datetime - ($dataPost['redmind'] * 60),
                    'minute_before' => isset($dataPost['redmind']) ? $dataPost['redmind'] : 0,
                    'repeated_time' => 0,
                    'is_snoozing' => 0,
                ];
            }
        }

        Remind::batchInsert($dataInsertInvitation);
        return true;
    }

    /**
     * Function update invitee
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataInvitee() {
//         if (empty($event_id)) return false;
//         return true;
    }

    /**
     * Function update Invitation
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataInvitation($event_id = null, $dataMegre = []) {
        if (empty($event_id))
            return false;
        if (empty($dataMegre))
            return true;

        //delete department table Invitation
        if (!empty($dataMegre['departmentOld'])) {
            Invitation::deleteAll([
                'event_id' => $event_id,
                'owner_id' => array_keys($dataMegre['departmentOld']),
                'company_id' => $this->_companyId,
                'owner_table' => Invitation::TABLE_DEPARTMENT,
            ]);
        }

        //Delete employee
        if (!empty($dataMegre['employeeOld'])) {
            Invitation::deleteAll([
                'event_id' => $event_id,
                'owner_id' => array_keys($dataMegre['employeeOld']),
                'company_id' => $this->_companyId,
                'owner_table' => Invitation::TABLE_EMPLOYEE,
            ]);
        }

        //add new department Invitation
        $dataInsertInvitation = [];
        if (!empty($dataMegre['departmentNew'])) {
            foreach ($dataMegre['departmentNew'] as $owner_id) {
                $dataInsertInvitation[] = [
                    'event_id' => $event_id,
                    'owner_id' => $owner_id,
                    'owner_table' => Invitation::TABLE_DEPARTMENT,
                ];
            }
        }

        //Add new department
        if (!empty($dataMegre['employeeNew'])) {
            foreach ($dataMegre['employeeNew'] as $val) {
                $dataInsertInvitation[] = [
                    'event_id' => $event_id,
                    'owner_id' => $val['id'],
                    'owner_table' => Invitation::TABLE_EMPLOYEE,
                ];
            }
        }
        
        Invitation::batchInsert($dataInsertInvitation);
        return true;
    }

    /**
     * Fuction to save employee's confirmation 
     */
    public function actionAttend() {
        $attendType = \Yii::$app->request->post('attend_type');
        $eventId = \Yii::$app->request->post('eventId');
        if (empty($attendType) || empty($eventId)) {
            return $this->sendResponse(true, Yii::t('member', 'Can not get data'), []);
        }

        $eventConfirmationType = EventConfirmationType::getByColumnName($attendType);
        if (!empty($eventConfirmationType)) {
            $eventConfirmation = EventConfirmation::getByEmployeeIdAndEventId(\Yii::$app->user->getId(), $eventId);
            if (empty($eventConfirmation)) {
                $eventConfirmation = new EventConfirmation();
                $eventConfirmation->event_id = $eventId;
                $eventConfirmation->employee_id = \Yii::$app->user->getId();
            }

            $eventConfirmation->event_confirmation_type_id = $eventConfirmationType->id;
            if (!$eventConfirmation->save()) {
                return $this->sendResponse(true, Yii::t('member', 'Can not save data'), []);
            }
        }

        return $this->sendResponse(false, "", []);
    }

    /**
     * Fuction display number of event confirmation type
     */
    public function actionViewAttend() {
        try {
            if ($eventId = \Yii::$app->request->get('eventId')) {
                if ($event = Event::getInfoAttend($eventId)) {
                    return $this->sendResponse(false, "", $event);
                }
            }
        } catch (\Exception $e) {
            return $this->sendResponse(true, Yii::t('member', 'Can not get data'), []);
        }

        return $this->sendResponse(false, "", []);
    }

    /**
     * Make project history
     *
     * @param array $dataPost
     * @return string
     */
    private function _makeEventHistory($dataPost) {
        $content = '';
        if (empty($dataPost)) {
            return $content;
        }

        $noSetting = \Yii::t('member', 'no setting');

//        $caledarName = empty($dataPost['calendar_id']) ? '' : Calendar::find()->select("name")->where(['id' => $dataPost['calendar_id']])->one();
        $caledarName = empty($dataPost['calendar_id']) ? '' : Calendar::getById($dataPost['calendar_id']);
        $redmindNew = empty($dataPost['redmind']) ? 0 : $dataPost['redmind'];
        $redmindOd = empty($dataPost['data_old']['remind']) ? 0 : $dataPost['data_old']['remind'];

        $isAlllDayOld = $dataPost['data_old']['event']['is_all_day'] == true ? \Yii::t('member', 'is_all_day') : \Yii::t('member', 'no setting');
        $isAllDayOldNew = $dataPost['is_all_day'] == true ? \Yii::t('member', 'is_all_day') : \Yii::t('member', 'no setting');
        if ($dataPost['is_all_day']) {
            $dataPost['start_datetime'] = $dataPost['start_datetime'] . '  00:00';
            $dataPost['end_datetime'] = $dataPost['end_datetime'] . '  00:00';
        }

        $dataReplace = array(
            \Yii::t('member', 'start datetime') => array($dataPost['data_old']['event']['start_datetime'] . ' ' . $dataPost['data_old']['event']['start_time'] => $dataPost['start_datetime']),
            \Yii::t('member', 'end datetime') => array($dataPost['data_old']['event']['end_datetime'] . ' ' . $dataPost['data_old']['event']['end_time'] => $dataPost['end_datetime']),
            \Yii::t('member', 'event name') => array($dataPost['data_old']['event']['name'] => $dataPost['name']),
            \Yii::t('member', 'calendar name') => array($dataPost['data_old']['calendar']['name'] => empty($dataPost['calendar_id']) ? '' : $caledarName->name),
            \Yii::t('member', 'address') => array($dataPost['data_old']['event']['address'] => $dataPost['address']),
            \Yii::t('member', 'color') => array($dataPost['data_old']['event']['color'] => $dataPost['color']),
            \Yii::t('member', 'event description op') => array($dataPost['data_old']['event']['description'] => $dataPost['description']),
            \Yii::t('member', 'remind') => array(\Yii::t('member', 'calendar_event_redmine_' . $redmindOd) => \Yii::t('member', 'calendar_event_redmine_' . $redmindNew)),
            \Yii::t('member', 'is_all_day') => array($isAlllDayOld => $isAllDayOldNew),
        );

        //Create log project history text.
        foreach ($dataReplace as $key => $value) {
            if (!empty($value)) {
                foreach ($value as $after => $befor) {
                    if ($after != $befor) {
                        $after = empty($after) ? \Yii::t('member', 'no setting') : $after;
                        $befor = empty($befor) ? \Yii::t('member', 'no setting') : $befor;
                        switch ($key) {
                            case \Yii::t('member', 'event description op'):
                                $description = !empty($befor) ? \Yii::t('member', 'event description op') . ' ' . \Yii::t('member', 'comment update after') : $noSetting;
                                $content .= '<li>' . $description . '</li>';
                                break;
                            default:
                                $content .= '<li>' . str_replace(array('{{title}}', '{{after}}', '{{befor}}'), array($key, $after, $befor), \Yii::t('member', 'message info content')) . '</li>';
                                break;
                        }
                    }
                }
            }
        }

        //Create text log for files.
        if (!empty($dataPost['fileList'])) {
            $content .= '<li>' . \Yii::t('member', 'add file') . '</li>';
            foreach ($dataPost['fileList'] as $key => $file) {
                $content .= '<div class="padding-left-20"><i><a href="' . \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $file['path'] . '">' . $file['name'] . '</a></i></div>';
            }
        }

        //Create text log for employee and department.
        $tplEmployess = $tmpDepartment = '';
        if (!empty($dataPost['employeeMegre'])) {
            if (!empty($dataPost['employeeMegre']['employeeNew']) || !empty($dataPost['employeeMegre']['employeeOld'])) {
                $content .= '<li>' . \Yii::t('member', 'change employee') . '</li>';
                if (!empty($dataPost['employeeMegre']['employeeOld'])) {
                    $content .= '<div class="padding-left-20">' . \Yii::t('member', 'delete') . '</div>';
                    foreach ($dataPost['employeeMegre']['employeeOld'] as $key => $val) {
                        $content .='<div class="padding-left-20"><a href="#/member/' . $key . '"><i>' . $val . '</i></a></div>';
                    }
                }

                if (!empty($dataPost['employeeMegre']['employeeNew'])) {
                    $content .= '<div class="padding-left-20">' . \Yii::t('member', 'add new') . '</div>';
                    foreach ($dataPost['employeeMegre']['employeeNew'] as $key => $val) {
                        $content .='<div class="padding-left-20"><a href="#/member/' . $val['id'] . '"><i>' . $val['firstname'] . '</i></a></div>';
                    }
                }
            }

            if (!empty($dataPost['employeeMegre']['departmentOld']) || !empty($dataPost['employeeMegre']['departmentNew'])) {
                $content .= '<li>' . \Yii::t('member', 'change department') . '</li>';

                if (!empty($dataPost['employeeMegre']['departmentOld'])) {
                    $content .= '<div class="padding-left-20">' . \Yii::t('member', 'delete') . '</div>';
                    foreach ($dataPost['employeeMegre']['departmentOld'] as $key => $val) {
                        $content .='<div class="padding-left-20"><i>' . $val . '</i></div>';
                    }
                }

                if (!empty($dataPost['employeeMegre']['departmentNew'])) {
                    $content .= '<div class="padding-left-20">' . \Yii::t('member', 'add new') . '</div>';
                    foreach ($dataPost['employeeMegre']['departmentNew'] as $departmentId) {
                        foreach ($dataPost['departmentlist'] as $valdepartmentlist) {
                            if ($departmentId == $valdepartmentlist['id']) {
                                $content .='<div class="padding-left-20"><i>' . $valdepartmentlist['name'] . '</i></div>';
                            }
                        }
                    }
                }
            }
        }
        
        return $content == '' ? false : "<ul>" . $content . "</ul>";
    }

    /*
     * Function add calendar
     */
    public function actionAddCalendar() {
        try {
            $request = \Yii::$app->request->post();
            if (!empty($request) && !empty($request['name']) && !empty($request['description'])) {
                $calendar = Calendar::getByName($request['name']);
                if (empty($calendar)) {
                    $calendar = new Calendar();
                    $calendar->name = $request['name'];
                    $calendar->description = $request['description'];

                    if (!$calendar->save()) {
                        $this->_message = $this->parserMessage($calendar->getErrors());
                        $this->_error = true;
                        throw new \Exception($this->_message);
                    }
                    
                    return $this->sendResponse(false, [], []);
                } else {
                    return $this->sendResponse(true, \Yii::t('member', 'error calendar name is existed'), []);
                }
            }
        } catch (\Exception $e) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }

    /*
     * Function edit calendar
     */
    public function actionEditCalendar() {
        try {
            $request = \Yii::$app->request->post();
            if (!empty($request) && !empty($request['id']) && !empty($request['name']) && !empty($request['description'])) {
                $calendar = Calendar::getById($request['id'], ['id']);
                if (!empty($calendar)) {
                    $isExist = Calendar::isExist($request['id'], $request['name']);
                    if (empty($isExist)) {
                        $calendar->name = $request['name'];
                        $calendar->description = $request['description'];
                        if (!$calendar->save(false)) {
                            $this->_message = $this->parserMessage($calendar->getErrors());
                            $this->_error = true;
                            throw new \Exception($this->_message);
                        }
                        
                        return $this->sendResponse(false, [], []);
                    } else {
                        return $this->sendResponse(true, \Yii::t('member', 'error calendar name is existed'), []);
                    }
                }
            }
        } catch (Exception $e) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }
    
    /**
     * Action delete calendar
     */
    public function actionDeleteCalendar() {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (!Calendar::deleteAll(['id' => \Yii::$app->request->get('calendarId')])) {
                throw new \Exception('delete error');
            }
            
            //Delete all event in this calendar.
            if (!Event::deleteAll(['calendar_id' => \Yii::$app->request->get('calendarId')])) {
                throw new \Exception('delete error');
            }
            
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_error = true;
            $this->_message = \Yii::t('common', 'delete error');
            $transaction->rollBack();
            return $this->sendResponse($this->_error, '', []);
        }
    
        return $this->sendResponse($this->_error, $this->_message, []);
    }
}
