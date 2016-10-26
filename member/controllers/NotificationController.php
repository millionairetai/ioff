<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Notification;

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
        $notifications = Notification::find()
                ->select(['content', 'datetime_created', 'type'])
                ->where(['employee_id' => Yii::$app->user->getId(),])
                ->orderBy('datetime_created DESC')
                ->limit(30)
//                ->offset(($currentPage - 1) * $itemPerPage)
                ->all();
        foreach ($notifications as $notification) {
            $collection[] = [
                'type' => $this->_changeTypeActivityToText($notification->type),
                'datetime_created' => $notification->datetime_created,
                'content' => $notification->content,
            ];
        }

        $objects = [];
        $objects['collection'] = $collection;
        return $this->sendResponse(false, '', $objects);
    }
    
    private function _changeTypeActivityToText($typeActivity) {
        switch ($typeActivity) {
            case 'create_activity_post';
                return \Yii::t('member', 'create activity post');
                break;
            case 'create_event';
                return \Yii::t('member', 'create event');
                break;
            case 'create_event_post';
                return \Yii::t('member', 'create event post');
                break;
            case 'create_project';
                return \Yii::t('member', 'create project');
                break;
            case 'create_project_post';
                return \Yii::t('member', 'create project post');
                break;
            case 'create_task';
                return \Yii::t('member', 'create task');
                break;
            case 'edit_event';
                return \Yii::t('member', 'edit event');
                break;
            case 'create_task_post';
                return \Yii::t('member', 'create task post');
                break;
            default :
                return $typeActivity;
        }
    }

}
