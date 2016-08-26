<?php

namespace member\controllers;

use common\models\Calendar;
use common\models\Event;
use common\models\Invitation;
use common\models\Invitee;
use common\models\File;
use common\models\Activity;
use common\models\EventConfirmation;
use common\models\Notification;
use common\models\Remind;
use common\models\Employee;
use common\models\Sms;
use common\models\EmployeeActivity;
use Yii;
use common\models\Project;
use common\models\EventConfirmationType;

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
                    'id' => $value['id'],
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
            if (!$ob = Event::find()->select(['id', 'name'])->where(['id' => $dataPost['id']])->one()) {
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
            
            $megreDataDeparmentAndEmployee = $this->_megreDataDeparmentAndEmployee($dataPost);
            //update table invitation
            $this->_updataInvitation($dataPost['id'], $megreDataDeparmentAndEmployee);
            
            $megreEmployee = $this->_megreDataEmployee($dataPost);
            //update table Event_confirmation
            $this->_updataEventConfirmation($dataPost['id'], $megreEmployee);
            
            //update table Remind
            $this->_updataRemind($dataPost, $megreEmployee, $ob);
            
            //move file
            File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $ob->id, File::TABLE_EVENT);
            
            //update table activity
            $activity = new Activity();
            $activity->owner_id = $ob->id;
            $activity->owner_table = Activity::TABLE_EVENT;
            $activity->parent_employee_id = 0;
            $activity->employee_id = \Yii::$app->user->getId();
            $activity->type = Activity::TYPE_EDIT_EVENT;
            $activity->content = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name;
            if (!$activity->save()) {
                throw new \Exception('Save record to table Activity fail');
            }
            
            //update table Notification
            if (!empty($megreEmployee['employees'])) {
                //save sms
                $dataInsertSms = $dataInsertNotification = [];
                foreach ($megreEmployee['employees'] AS $key => $val) {
                    $dataInsertNotification[] = [
                            'owner_id'    => $ob->id,
                            'owner_table' => Event::tableName(),
                            'employee_id' => $val,
                            'type'        =>  Activity::TYPE_EDIT_EVENT,
                            'content'     => \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name,
                            'owner_employee_id' => 0
                    ];

                    $dataInsertInvitee[] = [
                            'event_id'    => $ob->id,
                            'employee_id' => $val,
                    ];
                    
                    if ($ob->sms) {
                        $dataInsertSms[] = [
                                'owner_id'    => $ob->id,
                                'employee_id' => $val,
                                'owner_table' => Event::tableName(),
                                'content'     => \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name,
                                'is_success'  => true,
                                'fee'         => 0,
                                'agency_gateway' => 'esms'
                                
                        ];
                    }
                }
                //update table invitee
                if (!\Yii::$app->db->createCommand()->batchInsert(Invitee::tableName(), array_keys($dataInsertInvitee[0]), $dataInsertInvitee)->execute()) {
                    throw new \Exception('Save record to table Project Participant fail');
                }
                
                if (!\Yii::$app->db->createCommand()->batchInsert(Notification::tableName(), array_keys($dataInsertNotification[0]), $dataInsertNotification)->execute()) {
                    throw new \Exception('Save record to table Project Participant fail');
                }
                
                if (!empty($dataInsertSms)) {
                    if (!\Yii::$app->db->createCommand()->batchInsert(SMS::tableName(), array_keys($dataInsertSms[0]), $dataInsertSms)->execute()) {
                        throw new \Exception('Save record to table Project Participant fail');
                    }
                }
            }
            $themeEmail = \common\models\EmailTemplate::getThemeEditEvent();
            $themeSms   = \common\models\SmsTemplate::getThemeEditEvent();
            
            //send email and sms
            if (!empty($megreEmployee['employees']) && ($ob->sms)) {
                $dataSend = [
                        '{creator name}' => \Yii::$app->user->identity->firstname,
                        '{event name}'  => $ob->name
                ];
                $employees = new Employee();
                foreach ($megreEmployee['employees'] as $item) {
                    $employees->sendMail($dataSend, $themeEmail);
                    $employees->sendSms($dataSend, $themeSms);
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
     * Fuction display detail od Event by id
     * @return multitype:unknown
     */
    public function actionViewEvent() {
        try {
            if ($calendarId = \Yii::$app->request->post('calendarId')) {
                if ($event = Event::getInfoEvent($calendarId)) {
                    return $this->sendResponse(false, "", $event);
                }
            }
            throw new \Exception(\Yii::t('member', 'Can not get event info'));
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
    private function _megreDataEmployee($dataPost = []) {
        if (empty($dataPost)) return false;
        
        $employeeOld = !empty($dataPost['data_old']['invitations']['departmentAndEmployee']['employeeList']) ? $dataPost['data_old']['invitations']['departmentAndEmployee']['employeeList'] : null;
        $employeeNew = Employee::getlistByepartmentIdsAndEmployeeIds($dataPost['departments'], $dataPost['members']);
        $result = [];
        if (!empty($employeeOld) && !empty($employeeNew['employeeList'])) {
            foreach ($employeeOld as $keyEmployessOld => $valEmployeeOld) {
                $result['employeeOld'][$keyEmployessOld] = $valEmployeeOld['id'];
                foreach ($employeeNew['employeeList'] as $keyMemberNew => $valMemberNew) {
                    $result['employeeNew'][$keyMemberNew] = $valMemberNew['id'];
                    $result['employees'][$keyMemberNew] = $valMemberNew['id'];
                    if ($valEmployeeOld['id'] == $valMemberNew['id']) {
                        unset($employeeOld[$keyEmployessOld]);
                        unset($employeeNew['employeeList'][$keyMemberNew]);
                        unset($result['employeeOld'][$keyEmployessOld]);
                        unset($result['employeeNew'][$keyMemberNew]);
                    }
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
    private function _megreDataDeparmentAndEmployee($dataPost = []) {
        if (empty($dataPost)) return false;
        
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
                'employeeOld'   => $employeeOld,
                'employeeNew'   => $employeeNew,
        ];
    }

    /**
     * Function update invitee
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataEventConfirmation($event_id = null, $dataMegre = []) {
        if (empty($event_id)) return false;
        if (empty($dataMegre)) return true;
        
        //Delete employee
        if (!empty($dataMegre['employeeOld'])) {
            EventConfirmation::deleteAll([
                    'company_id'  => $this->_companyId,
                    'employee_id' => array_values($dataMegre['employeeOld']),
                    'event_id'    => $event_id,
            ]);
        }
        
        //Add new employee
        $dataInsertInvitation = [];
        if (!empty($dataMegre['employeeNew'])) {
            foreach ($dataMegre['employeeNew'] as $val) {
                $dataInsertInvitation[] = [
                        'employee_id' => $val,
                        'event_id'    => $event_id
                ];
            }
        }
         
        if (!empty($dataInsertInvitation)) {
            if (!\Yii::$app->db->createCommand()->batchInsert(EventConfirmation::tableName(), array_keys($dataInsertInvitation[0]), $dataInsertInvitation)->execute()) {
                throw new \Exception('Save record to table Project Participant fail');
            }
        }
        return true;
    }

    /**
     * Function update invitee
     *
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataRemind($dataPost = [], $dataMegre = [], $object = null) {
        if (empty($dataPost['id'])) return false;
        if (empty($dataMegre)) return true;
        if (empty($object)) return true;
        
        $event_id = $dataPost['id'];
        //Delete employee
        if (!empty($dataMegre['employeeOld'])) {
            Remind::deleteAll([
                    'company_id'  => $this->_companyId,
                    'employee_id' => array_values($dataMegre['employeeOld']),
                    'owner_id'    => $event_id,
                    'owner_table' => Event::tableName(),
            ]);
        }
        //Add new employee
        $dataInsertInvitation = [];
        if (!empty($dataMegre['employeeNew'])) {
            foreach ($dataMegre['employeeNew'] as $val) {
                $dataInsertInvitation[] = [
                        'employee_id' => $val,
                        'owner_id'    => $event_id,
                        'owner_table' => Event::tableName(),
                        'content'     => $dataPost['name'],
                        'remind_datetime' => $object->start_datetime - ($dataPost['redmind'] * 60),
                        'minute_before' => $dataPost['redmind'],
                        'repeated_time' => 0,
                        'is_snoozing'   => 0,
                ];
            }
        }
        if (!empty($dataInsertInvitation)) {
            if (!\Yii::$app->db->createCommand()->batchInsert(Remind::tableName(), array_keys($dataInsertInvitation[0]), $dataInsertInvitation)->execute()) {
                throw new \Exception('Save record to table Project Participant fail');
            }
        }
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
        if (empty($event_id)) return false;
        if (empty($dataMegre)) return true;
        
        //delete department table Invitation
        if (!empty($dataMegre['departmentOld'])) {
            Invitation::deleteAll([
                    'event_id'    => $event_id,
                    'owner_id'    => array_keys($dataMegre['departmentOld']),
                    'company_id'  => $this->_companyId,
                    'owner_table' => Invitation::TABLE_DEPARTMENT,
            ]);
        }
       
        //Delete employee
        if (!empty($dataMegre['employeeOld'])) {
            Invitation::deleteAll([
                    'event_id'    => $event_id,
                    'owner_id'    => array_keys($dataMegre['employeeOld']),
                    'company_id'  => $this->_companyId,
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
                        'event_id'  => $event_id,
                        'owner_id'    => $val['id'],
                        'owner_table' => Invitation::TABLE_EMPLOYEE,
                ];
            }
        }
        if (!empty($dataInsertInvitation)) {
            if (!\Yii::$app->db->createCommand()->batchInsert(Invitation::tableName(), array_keys($dataInsertInvitation[0]), $dataInsertInvitation)->execute()) {
                throw new \Exception('Save record to table Project Participant fail');
            }
        }
        return true;
    }
    
    /**
     * Fuction display detail od Event by id
     * @return multitype:unknown
     */
    public function actionAttend() {
        $attend_type = \Yii::$app->request->post('attend_type');
        $calendarId = \Yii::$app->request->post('calendarId');
        if (empty($attend_type) || empty($calendarId)) {
            return $this->sendResponse(true, "", 'Save record to table event_confirmation_type fail');
        }
        $EventConfirmationType = EventConfirmationType::find()->select(['id', 'name'])->where(['column_name' => $attend_type])->one();
        
        if (!empty($EventConfirmationType)) {
            $eventConfirmation = EventConfirmation::find()
                ->where(['company_id' => $this->_companyId, 'employee_id' => \Yii::$app->user->getId(), 'event_id' => $calendarId])
                ->one();
            if (empty($eventConfirmation)) {
                return $this->sendResponse(true, "Get EventConfirmation info fail", []);
            }
            $eventConfirmation->event_confirmation_type_id = $EventConfirmationType->id;
            if (!$eventConfirmation->update()) {
                throw new \Exception('Save record to table eventConfirmation fail');
            }
        }
        
        return $this->sendResponse(false, "", []);
    }
}
