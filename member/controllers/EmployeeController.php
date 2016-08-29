<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Employee;

class EmployeeController extends ApiController {

    // Get all calendar id from array
    public function actionSearch() {
        $objects = [];
        $keyword = Yii::$app->request->post('keyword');
        $departments = Yii::$app->request->post('departments', []);
        $members = Yii::$app->request->post('members', []);
        $manager = Yii::$app->request->post('manager', []);

        $query = Employee::find()
                    ->select(['id', 'email', 'firstname', 'lastname', 'profile_image_path'])
                    ->andCompanyId()->andWhere(['like', 'firstname', $keyword]);

        //check department
        if (!empty($departments)) {
            $query->andWhere(['not in', 'department_id', $departments]);
        }

        //check manager
        if (isset($manager['id'])) {
            $query->andWhere(['!=', 'id', $manager['id']]);
        }

        //check member
        if (!empty($members)) {
            $ids = [];
            foreach ($members as $mb) {
                $ids[] = $mb['id'];
            }
            $query->andWhere(['not in', 'id', $ids]);
        }

        if ($employees = $query->all()) {
            foreach ($employees as $employee) {
                $objects[] = [
                    'id' => $employee->id,
                    'firstname' => $employee->getFullName(),
                    'email' => $employee->email,
                    'image' => $employee->getImage()
                ];
            }
        }

        return $this->sendResponse(false, "", $objects);
    }

}
