<?php

namespace member\controllers;

use Yii;
use common\models\TaskGroup;

class TaskGroupController extends ApiController {

    /**
     * Get task group list
     */
    public function actionGetTaskGroups() {
        $objects = [];
        $collection = [];
        $taskGroups = TaskGroup::getByProjectId(Yii::$app->request->get('project_id'));
        foreach ($taskGroups as $taskGroup) {
            $collection[] = [
                'id' => $taskGroup['id'],
                'name' => $taskGroup['name']
            ];
        }

        $objects['collection'] = $collection;
        return $this->sendResponse(false, "", $objects);
    }

}
