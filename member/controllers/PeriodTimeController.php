<?php

namespace member\controllers;

use Yii;
use common\models\PeriodTime;

class PeriodTimeController extends ApiController {

    /**
     * Get period time.
     */
    public function actionGets() {
        $objects = [];
        if ($periodTimes = PeriodTime::gets()) {
            foreach($periodTimes as $item) {
                $objects[] = [
                    'month_value' => $item['month_value'],
                    'name' => $item['name'],
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

}
