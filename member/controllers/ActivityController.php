<?php

namespace member\controllers;

use Yii;
use common\models\Activity;

class ActivityController extends ApiController {

    /**
     * Get list of actions
     */
    public function actionIndex() {
//    return $this->sendResponse(false, "", Action::getTranslation());
    }

    /**
     * View company info
     */
    public function actionView() {
        $objects = [];
        try {
            $company = Company::getDetailByCompanyId(Yii::$app->user->identity->company_id);
            $company['total_storage'] = floor($company['total_storage'] / (1024 * 1024));
            $company['expired_date'] = empty($company['expired_date']) ? '--' : \Yii::$app->formatter->asDate($company['expired_date']);
            $company['start_date'] = \Yii::$app->formatter->asDate($company['start_date']);
            if (empty($company)) {
                throw new \Exception;
            }

            //Get person who create company's account.
            $employee = \common\models\Employee::getById($company['created_employee_id'], [
                'firstname', 'lastname', 'email', 'mobile_phone', 'street_address_1']);
            if (empty($employee)) {
                throw new \Exception;
            }
            $company['employee'] = [
                'name' => $employee->fullname,
                'mobile_phone' => $employee->mobile_phone,
                'email' => $employee->email,
                'address' => $employee->street_address_1
            ];

            $objects = ['company' => $company,];
            return $this->sendResponse(false, "", $objects);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }

}
