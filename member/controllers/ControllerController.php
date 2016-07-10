<?php

namespace member\controllers;

use Yii;
use common\models\Controller;

class ControllerController extends ApiController {

    /**
     * Get list of controllers
     */
    public function actionIndex() {
        return $this->sendResponse(false, "", Controller::find()->select('id, name')->asArray()->all());
    }

}
