<?php

namespace member\controllers;

use Yii;
use common\models\Activity;
use common\models\Annoucement;

class AnnoucementController extends ApiController {

    //Add annoucement
    public function actionAdd() {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $post = Yii::$app->request->post();
            if ($annoucement = new Annoucement()) {
                $annoucement->attributes = Yii::$app->request->post();
                $annoucement->date_new_to = strtotime($annoucement->date_new_to);
                $annoucement->employee_id = Yii::$app->user->identity->id;
                $annoucement->company_id = Yii::$app->user->identity->company_id;
                $annoucement->description_parse = strip_tags($annoucement->description);
                if ($annoucement->save() === false) {
                    $this->_message = $this->parserMessage($annoucement->getErrors());
                    return $this->sendResponse(true, $this->_message, []);
                }
                //Insert into activity
                $activity = new Activity();
                $activity->owner_id = $annoucement->id;
                $activity->owner_table = Activity::TABLE_ANNOUCEMENT;
                $activity->parent_employee_id = 0;
                $activity->employee_id = \Yii::$app->user->getId();
                $activity->type = Activity::TYPE_CREATE_ANNOUCEMENT;
                $activity->content = '';
                if ($activity->save() === false) {
                    throw new \Exception('Save record to table Activity fail');
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
                    'activity_object' => $annoucement->description,
//                    'activity_content_parse' => $annoucement->description_parse,
                    'annoucement' => [
                        'title' => $annoucement->title,
                        'content' => $annoucement->description,
                        'is_importance' => $annoucement->is_importance,
                    ]
                ];

                $transaction->commit();
                return $this->sendResponse($this->_error, $this->_message, ['activity' => $return]);
            }

            throw new \Exception('Can not initialize object');
        } catch (\Exception $ex) {
            $transaction->rollBack();
            $this->_error = true;
            return $this->sendResponse($this->_error, \Yii::t('member', 'error_system'), []);
        }

        return $this->sendResponse(false, "", []);
    }

    //Get annoucement
    public function actionGetAnnoucements($currentPage) {
        $objects = [];
        $collection = [];
        try {
            $annoucements = Annoucement::getAnnoucements($currentPage);
            if (!empty($annoucements['annoucements'])) {
                foreach ($annoucements['annoucements'] as $annoucement) {
                    $collection[$annoucement->id] = [
                        'employee' => [
                            'fullname' => $annoucement->employee->fullname,
                            'avatar' => $annoucement->employee->image,
                            'id' => $annoucement->employee->id,
                        ],
                        'title' => $annoucement->title,
                        'id' => $annoucement->id,
                        'is_importance' => $annoucement->is_importance,
                        'date_created' => Yii::$app->formatter->asDate($annoucement->datetime_created),
                    ];
                }

                if ($activities = Activity::getActivityIdsByAnnoucementIds(array_keys($collection))) {
                    foreach ($activities as $key => $activity) {
                        $collection[$key]['activity'] = ['id' => $activity['id']];
                    }
                }
            }

            $objects['annoucements'] = $collection;
            $objects['totalPage'] = $annoucements['totalPage'];
            return $this->sendResponse(false, "", $objects);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }

}
