<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Notification;
use common\models\Activity;

class NotificationController extends ApiController {

    //Count notification
    public function actionCount() {
        return $this->sendResponse(false, "", Notification::find()->where([
                            'employee_id' => Yii::$app->user->getId(),
                            'is_seen' => \common\components\db\ActiveRecord::VAL_FALSE
                        ])->count()
        );
    }

    /**
     * Get notfication list of employee login.
     */
    public function actionGetNotifications() {
        $collection = [];
        $notificationIds = [];
        $employee = new \common\models\Employee();
        
        try {
            $result = Notification::getByEmployeeId(Yii::$app->user->identity->id, Yii::$app->request->post('currentPage'));
            if ($result['notification']) {
                foreach ($result['notification'] as $notification) {
                    $notificationIds[] = $notification['id'];
                    $employee->firstname = $notification['firstname'];
                    $employee->lastname = $notification['lastname'];
                    $employee->profile_image_path = $notification['profile_image_path'];
                    $collection[] = [
                        'url' => $this->_makeUrlFromId($notification),
                        'avatar' => $employee->image,
                        'employee_name' => $employee->fullname,
                        'activity_action' => $this->_changeActivityTypeToText($notification['type']),
                        'activity_object' => $this->_getActivityName($notification),
                        'datetime_created' => $notification['datetime_created'],
                    ];
                }
            }

            //Update is_seen.
            if (!empty($notificationIds)) {
                Notification::updateAll(['is_seen'=> Notification::VAL_TRUE], ['id' => $notificationIds]);
            }
            $objects = [];
            $objects['notifications'] = $collection;
            $objects['totalCount'] = $result['totalRow'][0]['total_row'];
            return $this->sendResponse(false, '', $objects);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), []);
        }
    }

    /**
     * Change activity type to text. Ex: create_project -> 'created project'
     * 
     * @param string $typeActivity - Ex: create_project -> 'created project'
     * @return string
     */
    private function _changeActivityTypeToText($typeActivity) {
        switch ($typeActivity) {
            case 'create_activity_post';
                return \Yii::t('member', 'create activity post');
                break;
            case Activity::TYPE_CREATE_EVENT:
                return \Yii::t('member', 'created event');
                break;
            case Activity::TYPE_CREATE_EVENT_POST:
                return \Yii::t('member', 'posted in event of');
                break;
            case Activity::TYPE_CREATE_PROJECT:
                return \Yii::t('member', 'created project');
                break;
            case Activity::TYPE_CREATE_PROJECT_POST:
                return \Yii::t('member', 'posted in project of');
                break;
            case Activity::TYPE_CREATE_TASK:
                return \Yii::t('member', 'created task');
                break;
            case Activity::TYPE_CREATE_TASK_POST:
                return \Yii::t('member', 'posted in task of');
                break;
            case Activity::TYPE_EDIT_EVENT:
                return \Yii::t('member', 'edited event');
                break;
            case Activity::TYPE_EDIT_TASK:
                return \Yii::t('member', 'edited task');
                break;
            case Activity::TYPE_EDIT_PROJECT:
                return \Yii::t('member', 'edited project');
                break;
            default :
                return $typeActivity;
        }
    }

    /**
     * Get name of activity from array. In that array only one item is set 
     *      Ex: project, task, event, task post, project post, event post.,
     *      the rest is empty. 
     * 
     * @param array $notification
     * @return string
     */
    private function _getActivityName($notification) {
        $actiAction = '';
        if (!empty($notification['project_name'])) {
            $actiAction = $notification['project_name'];
        }

        if (!empty($notification['task_name'])) {
            $actiAction = $notification['task_name'];
        }

        if (!empty($notification['event_name'])) {
            $actiAction = $notification['event_name'];
        }

        if (!empty($notification['task_p_name'])) {
            $actiAction = $notification['task_p_name'];
        }

        if (!empty($notification['event_p_name'])) {
            $actiAction = $notification['event_p_name'];
        }

        if (!empty($notification['project_p_name'])) {
            $actiAction = $notification['project_p_name'];
        }

        return $actiAction;
    }

    /**
     * Make url from by get id in array. In that array only one item is set 
     *      Ex: project_id, task_id, event_id, task_p_id, project_p_id, event_p_id,
     *      the rest is empty. 
     * 
     * @param array $notification
     * @return string
     */
    private function _makeUrlFromId($notification) {
        $url = '';
        if (!empty($notification['project_id'])) {
            $url = '#/viewProject/' . $notification['project_id'];
        }

        if (!empty($notification['task_id'])) {
            $url = '#/viewTask/' . $notification['task_id'];
        }

        if (!empty($notification['event_id'])) {
            $url = '#/viewEvent/' . $notification['event_id'];
        }

        if (!empty($notification['task_p_id'])) {
            $url = '#/viewTask/' . $notification['task_p_id'];
        }

        if (!empty($notification['project_p_id'])) {
            $url = '#/viewProject/' . $notification['project_p_id'];
        }

        if (!empty($notification['event_p_id'])) {
            $url = '#/viewEvent/' . $notification['event_p_id'];
        }

        return $url;
    }

}
