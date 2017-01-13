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
     * Get activity of company for this employee
     */
    public function actionGetActivity() {
        $isSkip = false;
        $activityIds = [];
        $objects = [];
        $collection = [];
        $item = null;
        $employee = new \common\models\Employee();

//        try {
        $result = Activity::getActivityWallByEmployeeId(Yii::$app->user->identity->id, Yii::$app->request->get('currentPage'));
        $activities = $result['activities'];
        if ($activities) {
            foreach ($activities as $activity) {
                $activityIds[] = $activity['activity_id'];
                $employee->firstname = $activity['firstname'];
                $employee->lastname = $activity['lastname'];
                $employee->profile_image_path = $activity['profile_image_path'];
                $item = [
//                        'url' => $this->_makeUrlFromId($activity),
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
                    case 'event': {
                            $item['event'] = [
                                'dayofweek' => $this->_getDayofWeek($activity['event_start_datetime'], Yii::$app->language),
                                'month' => $this->_getMonth($activity['event_start_datetime'], Yii::$app->language),
                                'day' => \Yii::$app->formatter->asDate($activity['event_start_datetime'], 'd'),
                                'name' => $activity['event_name'],
                                'id' => $activity['event_id'],
                                'startdatetitme' => \Yii::$app->formatter->asDateTime($activity['event_start_datetime']),
                            ];

                            if (empty($item['event']['name'])) {
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

                $collection[] = $item;
            }
            
            //Get comment and bind into array from activityId.
        }

        $objects['activities'] = $collection;
        $objects['totalCount'] = $result['totalRow'][0]['total_row'];
        return $this->sendResponse(false, "", $objects);
//        } catch (\Exception $ex) {
//            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
//        }
    }

    private function _getItem() {
        
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

        if (strlen($descriptionParse) > 500) {
            $descriptionParse = substr($descriptionParse, 0, 500) . '...';
        }
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

//        if (!empty($activity['firstname'])) {
//            $actiAction = $activity['firstname'];
//        }
//
//        if (!empty($activity['lastname'])) {
//            $actiAction = $activity['lastname'];
//        }
//
//        if (!empty($activity['profile'])) {
//            $actiAction = $activity['project_p_name'];
//        }

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