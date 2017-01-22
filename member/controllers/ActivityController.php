<?php

namespace member\controllers;

use Yii;
use common\models\Activity;
use common\models\Like;
use common\models\Comment;
use common\models\ActivityPost;
use common\models\ActivityPostParticipant;
use common\models\ActivityPostEmployee;

class ActivityController extends ApiController {

    /**
     * Get activity of company for this employee
     */
    public function actionGetActivity() {
        $isSkip = false;
        $activityIds = [];
        $objects = [];
        $collection = [];
        $item = null;
        $employee = new \common\models\Employee();

        try {
            $result = Activity::getActivityWallByEmployeeId(Yii::$app->user->identity->id, Yii::$app->request->get('currentPage'));
            $activities = $result['activities'];
            if ($activities) {
                foreach ($activities as $activity) {
                    $employee->firstname = $activity['firstname'];
                    $employee->lastname = $activity['lastname'];
                    $employee->profile_image_path = $activity['profile_image_path'];
                    $item = [
                        'total_comment' => $activity['total_comment'],
                        'total_like' => $activity['total_like'],
                        'is_liked' => !empty($activity['like_employee_id']) ? true : false,
                        'activity_id' => $activity['activity_id'],
                        'activity_type' => $activity['owner_table'],
                        'activity_action' => $this->_changeActivityTypeToText($activity['type']),
                        'avatar' => $employee->image,
                        'employee_id' => $activity['employee_id'],
                        'employee_name' => $employee->fullname,
                        'datetime_created' => \Yii::$app->formatter->asDateTime($activity['datetime_created']),
                        'activity_object' => $this->_getActivityName($activity),
                        'activity_content_parse' => $this->_getActivityDescriptionParse($activity),
                    ];

                    switch ($activity['owner_table']) {
                        case 'activity_post': {
                                if (empty($activity['activity_post_content'])) {
                                    $isSkip = true;
                                }
                            }
                            break;
                        case 'task': {
                                $item['task'] = [
                                    'name' => $this->_getActivityName($activity),
                                    'id' => $activity['task_id']
                                ];

                                if (empty($item['task']['name'])) {
                                    $isSkip = true;
                                }
                            }
                            break;
                        case 'task_post': {
                                $item['task_post'] = [
                                    'name' => $this->_getActivityName($activity),
                                    'id' => $activity['p_task_id']
                                ];

                                if (empty($item['task_post']['name'])) {
                                    $isSkip = true;
                                }
                            }
                            break;
                        case 'event': {
                                $item['event'] = [
                                    'dayofweek' => $this->_getDayofWeek($activity['event_start_datetime'], Yii::$app->language),
                                    'month' => $this->_getMonth($activity['event_start_datetime'], Yii::$app->language),
                                    'day' => \Yii::$app->formatter->asDate($activity['event_start_datetime'], 'd'),
                                    'name' => $activity['event_name'],
                                    'id' => $activity['event_id'],
                                    'startdatetitme' => \Yii::$app->formatter->asDateTime($activity['event_start_datetime']),
                                    'enddatetitme' => \Yii::$app->formatter->asDateTime($activity['event_end_datetime']),
                                ];

                                if (empty($item['event']['name'])) {
                                    $isSkip = true;
                                }
                            }

                            break;
                        case 'event_post': {
                                $item['event_post'] = [
                                    'dayofweek' => $this->_getDayofWeek($activity['p_event_start_datetime'], Yii::$app->language),
                                    'month' => $this->_getMonth($activity['p_event_start_datetime'], Yii::$app->language),
                                    'day' => \Yii::$app->formatter->asDate($activity['p_event_start_datetime'], 'd'),
                                    'name' => $activity['p_event_name'],
                                    'id' => $activity['p_event_id'],
                                    'startdatetitme' => \Yii::$app->formatter->asDateTime($activity['p_event_start_datetime']),
                                    'enddatetitme' => \Yii::$app->formatter->asDateTime($activity['p_event_end_datetime']),
                                ];

                                if (empty($item['event_post']['name'])) {
                                    $isSkip = true;
                                }
                            }

                            break;
                        case 'project': {
                                $item['project'] = [
                                    'name' => $this->_getActivityName($activity),
                                    'id' => $activity['project_id'],
                                ];

                                //skip item which don't have data because thatuser doesn't have authority
                                if (empty($item['project']['name'])) {
                                    $isSkip = true;
                                }
                                break;
                            }
                        case 'project_post': {
                                $item['project_post'] = [
                                    'name' => $this->_getActivityName($activity),
                                    'id' => $activity['p_project_id'],
                                ];

                                //skip item which don't have data because thatuser doesn't have authority
                                if (empty($item['project_post']['name'])) {
                                    $isSkip = true;
                                }
                                break;
                            }
                        case 'employee': {
                                $employee->firstname = $activity['new_employeee_firstname'];
                                $employee->lastname = $activity['new_employeee_lastname'];
                                $employee->profile_image_path = $activity['new_employeee_profile_image_path'];
                                $employee->department_id = $activity['department_id'];
                                $item['employee'] = [
                                    'fullname' => $employee->fullname,
                                    'avatar' => $employee->image,
                                    'department' => !empty($employee->department->name) ? $employee->department->name : '',
                                    'id' => $activity['new_employeee_id'],
                                ];

                                break;
                            }
                    }

                    if ($isSkip) {
                        $isSkip = false;
                        continue;
                    }

                    //Get list activityId to get comment list.
                    $activityIds[] = $activity['activity_id'];
                    $collection[$activity['activity_id']] = $item;
                }

                //Get comment and bind into array from activityId.
                if ($comments = Comment::getCommentByActivityIds($activityIds)) {
                    //Bind to activity
                    foreach ($comments as $comment) {
                        $employee->firstname = $comment['firstname'];
                        $employee->lastname = $comment['lastname'];
                        $employee->profile_image_path = $comment['profile_image_path'];
                        $collection[$comment['activity_id']]['comments'][$comment['comment_id']] = [
                            'content' => $comment['content'],
                            'datetime' => \Yii::$app->formatter->asDateTime($comment['datetime_created']),
                            'total_like' => $comment['total_like'],
                            'is_liked' => !empty($comment['like_employee_id']) ? true : false,
                            'employee' => [
                                'avatar' => $employee->image,
                                'fullname' => $employee->fullname,
                                'id' => $comment['comment_employee_id'],
                            ],
                        ];
                    }
                }
            }

            $objects['activities'] = $collection;
            $objects['totalCount'] = !empty($result['totalRow'][0]['total_row']) ? $result['totalRow'][0]['total_row'] : 0;
            $objects['profile'] = [
                'avatar' => Yii::$app->user->identity->image,
                'id' => Yii::$app->user->identity->id,
            ];
            return $this->sendResponse(false, "", $objects);
        } catch (\Exception $ex) {
            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
        }
    }

    /**
     * Like activity
     */
    public function actionLike() {
        try {
            $transaction = \Yii::$app->db->beginTransaction();
            if ($activityId = Yii::$app->request->post('activityId')) {
                //save into like table.
                $like = new Like();
                $like->employee_id = Yii::$app->user->identity->id;
                $like->owner_id = $activityId;
                $like->owner_table = Like::TABLE_ACTIVITY;
                if ($like->save() === false) {
                    throw new \Exception('Can not like');
                }
                //increase like 1 step in comment
                Activity::updateAllCounters(['total_like' => 1], ['id' => $activityId]);
                $transaction->commit();
                return $this->sendResponse($this->_error, '', []);
            }

            throw new \Exception('Can not like');
        } catch (\Exception $ex) {
            $transaction->rollBack();
            $this->_error = true;
            return $this->sendResponse($this->_error, \Yii::t('member', 'error_system'), []);
        }

        return $this->sendResponse(false, '', []);
    }

    /**
     * Like activity
     */
    public function actionAddMessage() {
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
                    'activity_action' => 'post activity',
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

    private function _getItem() {
        
    }

    private function _insertActivityPostSlaveTable($post, $activityPost) {
        $departmentIds = [];
        $employeeIds = [];
        foreach ((array) $post['departments'] as $departmentId) {
            $departmentIds[] = $departmentId;
            $activityPostPartcipant[] = [
                'activity_post_id' => $activityPost['id'],
                'owner_id' => $departmentId,
                'owner_table' => 'department',
            ];
        }

        foreach ((array) $post['employees'] as $employee) {
            $employeeIds[] = $employee['id'];
            $activityPostPartcipant[] = [
                'activity_post_id' => $activityPost['id'],
                'owner_id' => $employee['id'],
                'owner_table' => 'employee',
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
    }

    /**
     * Change activity type to text. Ex: create_project -> 'created project'
     * 
     * @param string $typeActivity - Ex: create_project -> 'created project'
     * @return string
     */
    private function _getActivityDescriptionParse($activity) {
        $descriptionParse = '';
        if (!empty($activity['event_description_parse'])) {
            $descriptionParse = $activity['event_description_parse'];
        }

        if (!empty($activity['project_description_parse'])) {
            $descriptionParse = $activity['project_description_parse'];
        }

        if (!empty($activity['task_description_parse'])) {
            $descriptionParse = $activity['task_description_parse'];
        }

        if (!empty($activity['p_event_description_parse'])) {
            $descriptionParse = $activity['p_event_description_parse'];
        }

        if (!empty($activity['p_project_description_parse'])) {
            $descriptionParse = $activity['p_project_description_parse'];
        }

        if (!empty($activity['p_task_description_parse'])) {
            $descriptionParse = $activity['p_task_description_parse'];
        }

        if (!empty($activity['activity_post_content_parse'])) {
            $descriptionParse = $activity['activity_post_content_parse'];
        }

//        if (strlen($descriptionParse) > 500) {
//            $descriptionParse = substr($descriptionParse, 0, 500) . '...';
//        }
        return $descriptionParse;
    }

    /**
     * Change activity type to text. Ex: create_project -> 'created project'
     * 
     * @param string $typeActivity - Ex: create_project -> 'created project'
     * @return string
     */
    private function _changeActivityTypeToText($typeActivity) {
        switch ($typeActivity) {
            case 'create_activity_post';
                return \Yii::t('member', 'create activity post');
                break;
            case Activity::TYPE_CREATE_EVENT:
                return \Yii::t('member', 'created event');
                break;
            case Activity::TYPE_CREATE_EVENT_POST:
                return \Yii::t('member', 'posted in event of');
                break;
            case Activity::TYPE_CREATE_PROJECT:
                return \Yii::t('member', 'created project');
                break;
            case Activity::TYPE_CREATE_PROJECT_POST:
                return \Yii::t('member', 'posted in project of');
                break;
            case Activity::TYPE_CREATE_TASK:
                return \Yii::t('member', 'created task');
                break;
            case Activity::TYPE_CREATE_TASK_POST:
                return \Yii::t('member', 'posted in task of');
                break;
            case Activity::TYPE_EDIT_EVENT:
                return \Yii::t('member', 'edited event');
                break;
            case Activity::TYPE_EDIT_TASK:
                return \Yii::t('member', 'edited task');
                break;
            case Activity::TYPE_EDIT_PROJECT:
                return \Yii::t('member', 'edited project');
                break;
            default :
                return $typeActivity;
        }
    }

    /**
     * Get name of activity from array. In that array only one item is set 
     *      Ex: project, task, event, task post, project post, event post.,
     *      the rest is empty. 
     * 
     * @param array $activity
     * @return string
     */
    private function _getActivityName($activity) {
        $actiAction = '';
        if (!empty($activity['project_name'])) {
            $actiAction = $activity['project_name'];
        }

        if (!empty($activity['task_name'])) {
            $actiAction = $activity['task_name'];
        }

        if (!empty($activity['event_name'])) {
            $actiAction = $activity['event_name'];
        }

        if (!empty($activity['p_task_name'])) {
            $actiAction = $activity['p_task_name'];
        }

        if (!empty($activity['p_project_name'])) {
            $actiAction = $activity['p_project_name'];
        }

        return $actiAction;
    }

    /**
     * Make url from by get id in array. In that array only one item is set 
     *      Ex: project_id, task_id, event_id, task_p_id, project_p_id, event_p_id,
     *      the rest is empty. 
     * 
     * @param array $activity
     * @return string
     */
    private function _makeUrlFromId($activity) {
        $url = '';
        if (!empty($activity['project_id'])) {
            $url = '#/viewProject/' . $activity['project_id'];
        }

        if (!empty($activity['task_id'])) {
            $url = '#/viewTask/' . $activity['task_id'];
        }

        if (!empty($activity['event_id'])) {
            $url = '#/viewEvent/' . $activity['event_id'];
        }

        if (!empty($activity['task_p_id'])) {
            $url = '#/viewTask/' . $activity['task_p_id'];
        }

        if (!empty($activity['project_p_id'])) {
            $url = '#/viewProject/' . $activity['project_p_id'];
        }

        if (!empty($activity['event_p_id'])) {
            $url = '#/viewEvent/' . $activity['event_p_id'];
        }

        return $url;
    }

    public function _getDayofWeek($datetime, $language) {
        $dayofweek = [];
        $dayofweek['vi'][1] = 'Thứ hai';
        $dayofweek['vi'][2] = 'Thứ ba';
        $dayofweek['vi'][3] = 'Thứ tư';
        $dayofweek['vi'][4] = 'Thứ năm';
        $dayofweek['vi'][5] = 'Thứ sáu';
        $dayofweek['vi'][6] = 'Thứ bảy';
        $dayofweek['vi'][7] = 'Chủ nhật';

        $dayofweek['en'][1] = 'Monday';
        $dayofweek['en'][2] = 'Thursday';
        $dayofweek['en'][3] = 'Wednesday';
        $dayofweek['en'][4] = 'Thursday';
        $dayofweek['en'][5] = 'Friday';
        $dayofweek['en'][6] = 'Saturday';
        $dayofweek['en'][7] = 'Sunday';

        $index = \Yii::$app->formatter->asDate($datetime, 'php:N');
        if (!$index || empty($dayofweek[$language][$index])) {
            return '';
        }

        return $dayofweek[$language][$index];
    }

    public function _getMonth($datetime, $language) {
        $month = [];

        $month['vi'][1] = 'Tháng 1';
        $month['vi'][2] = 'Tháng 2';
        $month['vi'][3] = 'Tháng 3';
        $month['vi'][4] = 'Tháng 4';
        $month['vi'][5] = 'Tháng 5';
        $month['vi'][6] = 'Tháng 6';
        $month['vi'][7] = 'Tháng 7';
        $month['vi'][8] = 'Tháng 8';
        $month['vi'][9] = 'Tháng 9';
        $month['vi'][10] = 'Tháng 10';
        $month['vi'][11] = 'Tháng 11';
        $month['vi'][12] = 'Tháng 12';

        $month['en'][1] = 'January';
        $month['en'][2] = 'February';
        $month['en'][3] = 'March';
        $month['en'][4] = 'April';
        $month['en'][5] = 'May';
        $month['en'][6] = 'June';
        $month['en'][7] = 'July';
        $month['en'][8] = 'August';
        $month['en'][9] = 'September';
        $month['en'][10] = 'October';
        $month['en'][11] = 'November';
        $month['en'][12] = 'December';

        $index = \Yii::$app->formatter->asDate($datetime, 'M');
        if (!$index || empty($month[$language][$index])) {
            return '';
        }

        return $month[$language][$index];
    }

}
