<?php

namespace member\controllers;

use Yii;
use common\models\Company;
use common\models\PlanType;

class PlanTypeController extends ApiController {

    /**
     * Get plan type list
     */
    public function actionGets() {
        $objects = [];
        if ($authorities = PlanType::getsIndexById()) {
            foreach($authorities as $item) {
                $objects[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

}
