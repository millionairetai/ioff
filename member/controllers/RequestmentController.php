<?php

namespace member\controllers;

use Yii;
use common\models\Activity;
use common\models\Requestment;
use common\models\RequestmentCategory;
use common\models\Notification;
use common\models\Sms;
use common\models\Status;
use common\models\EmailTemplate;
use common\models\SmsTemplate;

class RequestmentController extends ApiController {

    //Add annoucement
    public function actionAdd() {
        $transaction = \Yii::$app->db->beginTransaction();
//        try {
            $post = Yii::$app->request->post();
            if ($requestment = new Requestment()) {
                $requestment->attributes = Yii::$app->request->post();
                $statusRequestment = Status::getByOwnerTableAndColumnName('requestment', Requestment::STATUS_COLUMN_NAME_INPROGESS);
                $requestment->from_datetime = !empty($requestment->from_datetime) ? strtotime($requestment->from_datetime) : 0;
                $requestment->to_datetime = !empty($requestment->to_datetime) ? strtotime($requestment->to_datetime) : 0;
                $requestment->company_id = Yii::$app->user->identity->company_id;
                $requestment->description_parse = strip_tags($requestment->description);
                $requestment->status_id = $statusRequestment['id'];
                if ($requestment->save() === false) {
                    $this->_message = $this->parserMessage($requestment->getErrors());
                    return $this->sendResponse(true, $this->_message, []);
                }

                //Insert into activity
                $activity = new Activity();
                $activity->owner_id = $requestment->id;
                $activity->owner_table = Activity::TABLE_REQUESTMENT;
                $activity->parent_employee_id = 0;
                $activity->employee_id = \Yii::$app->user->getId();
                $activity->type = Activity::TYPE_CREATE_REQUESTMENT;
                $activity->content = '';
                if ($activity->save() === false) {
                    throw new \Exception('Save record to table Activity fail');
                }

                //notification & sms
                $insertArr = [
                    'owner_id' => $requestment->id,
                    'employee_id' => $requestment->review_employee_id,
                    'owner_table' => Activity::TABLE_REQUESTMENT,
                    'owner_employee_id' => \Yii::$app->user->getId(),
                    'type' => Activity::TYPE_CREATE_REQUESTMENT,
                    'content' => '',
                ];
                
                if ((new Notification())->insertByArr($insertArr) === false) {
                    throw new \Exception('Insert record to Notification table fail');
                }
                
                //Send email
                $themeEmail = EmailTemplate::getTheme(EmailTemplate::CREATE_REQUESTMENT);
                $themeSms = SmsTemplate::getTheme(SmsTemplate::CREATE_REQUESTMENT);
                $reviewEmployee = \Yii::$app->request->post('review_employee');
                $dataSend = [
                    '{employee name}' => $reviewEmployee['firstname'],
                    '{creator name}' => \Yii::$app->user->identity->fullname,
                    '{requestment title}' => $requestment->title,
                    '{activity id}' => $activity->id,
                    '{host}' => Yii::$app->params['companyDomain']
                ];

                $employee = new \common\models\Employee();
                $employee->email = $reviewEmployee['email'];
                $employee->sendMail($dataSend, $themeEmail);
                if ($post['sms']) {
                    $employee->sendSms($dataSend, $themeSms);
                }
                
                $insertArr = [
                    'owner_id' => $requestment->id,
                    'employee_id' => $requestment->review_employee_id,
                    'owner_table' => Activity::TABLE_REQUESTMENT,
                    'content' => 'add requestment',
                    'is_success' => true, 
                    'fee' => 0,
                    'agency_gateway' => 'esms'
                ];

                if ((new Sms())->insertByArr($insertArr) === false) {
                    throw new \Exception('Insert record to Sms table fail');
                }
                
                $requestmentCategory = RequestmentCategory::getById($requestment->requestment_category_id, ['name'], false);
                if (empty($requestmentCategory['name'])) {
                    throw new \Exception('Requestment category name is empty');
                }
                
                $return = [
                    'total_comment' => 0,
                    'total_like' => 0,
                    'is_liked' => false,
                    'activity_id' => $activity->id,
                    'activity_type' => $activity->owner_table,
//                    'activity_action' => 'post activity',
                    'avatar' => Yii::$app->user->identity->image,
                    'employee_id' => Yii::$app->user->identity->id,
                    'employee_name' => Yii::$app->user->identity->fullname,
                    'datetime_created' => \Yii::$app->formatter->asDateTime($activity->datetime_created),
                    'activity_object' => $requestment->description,
//                    'activity_content_parse' => $requestment->description_parse,
                    'requestment' => [
                        'title' => $requestment->title,
                        'content' => $requestment->description,
                        'avatar_from' => Yii::$app->user->identity->image,
                        'requestment_category' => $requestmentCategory['name'],
                        'status' => Requestment::STATUS_COLUMN_NAME_INPROGESS,
                    ]
                ];
                
                if ($requestment->from_datetime) {
                    $return['requestment']['from_datetime'] = Yii::$app->formatter->asDatetime($requestment->from_datetime);
                }
                
                if ($requestment->to_datetime) {
                    $return['requestment']['to_datetime'] = Yii::$app->formatter->asDatetime($requestment->to_datetime);
                }

                $transaction->commit();
                return $this->sendResponse($this->_error, $this->_message, ['requestment' => $return]);
            }

            throw new \Exception('Can not initialize object');
//        } catch (\Exception $ex) {
//            $transaction->rollBack();
//            $this->_error = true;
//            return $this->sendResponse($this->_error, \Yii::t('member', 'error_system'), []);
//        }

        return $this->sendResponse(false, "", []);
    }

    //Get annoucement
    public function actionGetAnnoucements($currentPage) {
        $objects = [];
        $collection = [];
        try {
            $requestments = Annoucement::getAnnoucements($currentPage);
            if (!empty($requestments['annoucements'])) {
                foreach ($requestments['annoucements'] as $requestment) {
                    $collection[$requestment->id] = [
                        'employee' => [
                            'fullname' => $requestment->employee->fullname,
                            'avatar' => $requestment->employee->image,
                            'id' => $requestment->employee->id,
                        ],
                        'title' => $requestment->title,
                        'id' => $requestment->id,
                        'is_importance' => $requestment->is_importance,
                        'date_created' => Yii::$app->formatter->asDate($requestment->datetime_created),
                    ];
                }

                if ($activities = Activity::getActivityIdsByAnnoucementIds(array_keys($collection))) {
                    foreach ($activities as $key => $activity) {
                        $collection[$key]['activity'] = ['id' => $activity['id']];
                    }
                }
            }

            $objects['annoucements'] = $collection;
            $objects['totalPage'] = $requestments['totalPage'];
            return $this->sendResponse(false, "", $objects);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }

}
