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
        $objects = [];
        $collection = [];
        $employee = new \common\models\Employee();

//        try {
            $result = Activity::getActivityWallByEmployeeId(Yii::$app->user->identity->id, Yii::$app->request->get('currentPage'));
            $activities = $result['activities'];
            if ($activities) {
                foreach ($activities as $activity) {
                    $employee->firstname = $activity['firstname'];
                    $employee->lastname = $activity['lastname'];
                    $employee->profile_image_path = $activity['profile_image_path'];
                    $collection[] = [
//                        'url' => $this->_makeUrlFromId($activity),
                        'activity_type' => $activity['owner_table'],
                        'activity_action' => $activity['type'],
                        'avatar' => $employee->image,
                        'employee_id' => $activity['employee_id'],
                        'employee_name' => $employee->fullname,
                        'activity_action' => $this->_changeActivityTypeToText($activity['type']),
                        'activity_object' => $this->_getActivityName($activity),
                        'activity_content_parse' => $this->_getActivityDescriptionParse($activity),
                        'datetime_created' => \Yii::$app->formatter->asDateTime($activity['datetime_created']),
                    ];
                }
            }

            $objects['activities'] = $collection;
            $objects['totalCount'] = $result['totalRow'][0]['total_row'];
            return $this->sendResponse(false, "", $objects);
//        } catch (\Exception $ex) {
//            return $this->sendResponse(true, \Yii::t('member', 'error_system'), '');
//        }
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

        if (!empty($activity['task_p_name'])) {
            $actiAction = $activity['task_p_name'];
        }

        if (!empty($activity['event_p_name'])) {
            $actiAction = $activity['event_p_name'];
        }

        if (!empty($activity['project_p_name'])) {
            $actiAction = $activity['project_p_name'];
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

}
