<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Notification;

class NotificationController extends ApiController {

    //Count notification
    public function actionCount() {
        return $this->sendResponse(false, "", 
                Notification::find()
                                ->where([
                                    'employee_id' => Yii::$app->user->getId(), 
                                    'is_seen' => \common\components\db\ActiveRecord::VAL_FALSE
                                ])
                                ->count()
        );
    }

}
