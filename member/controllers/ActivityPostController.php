<?php

namespace member\controllers;

use Yii;
use common\models\Activity;
use common\models\ActivityPost;
use common\models\ActivityPostParticipant;
use common\models\ActivityPostEmployee;

class ActivityPostController extends ApiController {

    /**
     * Add activity post
     */
    public function actionAdd() {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $post = Yii::$app->request->post();
            if ($activityPost = new ActivityPost()) {
                $activityPost->attributes = Yii::$app->request->post();
                $activityPost->employee_id = Yii::$app->user->identity->id;
                $activityPost->company_id = Yii::$app->user->identity->company_id;
                $activityPost->is_public = Yii::$app->request->post('option') ? false : true;
                $activityPost->content_parse = strip_tags($activityPost->content);
                if ($activityPost->save() === false) {
                    $this->_message = $this->parserMessage($activityPost->getErrors());
                    return $this->sendResponse(true, $this->_message, []);
                }
                //Insert into activity
                $activity = new Activity();
                $activity->owner_id = $activityPost->id;
                $activity->owner_table = Activity::TABLE_ACTIVITY_POST;
                $activity->parent_employee_id = 0;
                $activity->employee_id = \Yii::$app->user->getId();
                $activity->type = Activity::TYPE_CREATE_ACTIVITY_POST;
                $activity->content = '';
                if ($activity->save() === false) {
                    throw new \Exception('Save record to table Activity fail');
                }

                //Add in activity post participant, activity post employee.
                if (!$activityPost->is_public) {
                    $this->_insertActivityPostSlaveTable($post, $activityPost);
                }

                $return = [
                    'total_comment' => 0,
                    'total_like' => 0,
                    'is_liked' => false,
                    'activity_id' => $activity->id,
                    'activity_type' => $activity->type,
//                    'activity_action' => 'post activity',
                    'avatar' => Yii::$app->user->identity->image,
                    'employee_id' => Yii::$app->user->identity->id,
                    'employee_name' => Yii::$app->user->identity->fullname,
                    'datetime_created' => \Yii::$app->formatter->asDateTime($activity->datetime_created),
                    'activity_object' => $activityPost->content,
                    'activity_content_parse' => $activityPost->content_parse,
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

        return $this->sendResponse(false, "", $comment);
    }

    /**
     * Like activity
     * 
     * @param array $post - post from user.
     * @param array $activityPost - array of activity post.
     * 
     * @return boolean
     */
    private function _insertActivityPostSlaveTable($post, $activityPost) {
        $departmentIds = [];
        $employeeIds = [];
        foreach ((array) $post['departments'] as $departmentId) {
            $departmentIds[] = $departmentId;
            $activityPostPartcipant[] = [
                'activity_post_id' => $activityPost['id'],
                'owner_id' => $departmentId,
                'owner_table' => ActivityPostParticipant::TABLE_DEPARTMENT,
            ];
        }

        foreach ((array) $post['employees'] as $employee) {
            $employeeIds[] = $employee['id'];
            $activityPostPartcipant[] = [
                'activity_post_id' => $activityPost['id'],
                'owner_id' => $employee['id'],
                'owner_table' => ActivityPostParticipant::TABLE_EMPLOYEE,
            ];
        }

        if (!empty($activityPostPartcipant)) {
            ActivityPostParticipant::batchInsert($activityPostPartcipant);
        }

        //Insert into activity post employee.
        ///Get employee id.
        $employeeIds = \common\models\Employee::getEmployeeIdByDepartmentIdAndEmployeeId($departmentIds, $employeeIds);
        if ($employeeIds) {
            foreach ($employeeIds as $employeeId) {
                $activityPostEmployee[] = [
                    'activity_post_id' => $activityPost['id'],
                    'employee_id' => $employeeId,
                ];
            }

            ActivityPostEmployee::batchInsert($activityPostEmployee);
        }

        return true;
    }

}
