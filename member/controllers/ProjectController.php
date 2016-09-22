<?php

namespace member\controllers;

use Yii;
use common\models\Project;
use common\models\Status;
use common\models\Priority;
use common\models\ProjectParticipant;
use common\models\Activity;
use common\models\EmployeeActivity;
use common\models\Notification;
use common\models\Employee;
use common\models\File;
use common\models\Sms;
use common\models\ProjectPost;
use common\models\Department;
use common\models\ProjectEmployee;
use common\components\db\ActiveRecord;

class ProjectController extends ApiController {

    /**
     * Get list project
     */
    public function actionIndex() {
        $collection = [];
        $itemPerPage = \Yii::$app->request->post('itemPerPage', 10);
        $currentPage = \Yii::$app->request->post('currentPage', 1);
        
        //fetch data
        $params = [':empolyee_id' => \Yii::$app->user->getId()];
        $result = Project::getProject($params, $currentPage, $itemPerPage);
        $totalItems = $this->getPagination($result['sql'], $currentPage, $itemPerPage, $params);
        foreach ($result['data'] as $item) {
            $collection[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'status_id' => $item['status_id'],
                'status' => $item['status_name'],
                'completed_percent' => $item['completed_percent'],
                'description' => strlen($item['description']) > 250 ? (substr($item['description'], 0, 70) . "...") : $item['description'],
                'theory' => $item['estimate_hour'] > 0 ? ((int) (($item['worked_hour'] / $item['estimate_hour'] ) * 100)) : 0,
            ];
        }
        
        $objects['collection'] = $collection;
        $objects['totalItems'] = (int) $totalItems;
        $objects['error'] = Yii::$app->session->getFlash('errorViewProject');
        return $this->sendResponse(false, "", $objects);
    }

    /**
     * add project
     */
    public function actionAdd() {
        $error = false;
        $message = "";
        $objects = [];
        $dataPost = [];

        $projectJson = \Yii::$app->request->post('project', '');
        if (strlen($projectJson)) {
            $dataPost = json_decode($projectJson, true);
        }
        
        $transaction = \Yii::$app->db->beginTransaction();
        
        //create object and validate data
        try {
            $ob = new Project();
            $ob->attributes = $dataPost;
            $ob->description_parse = $ob->description;
            $ob->start_datetime = $ob->start_datetime ? strtotime($ob->start_datetime) : null;
            $ob->duedatetime = $ob->duedatetime ? strtotime($ob->duedatetime) : null;
            if (isset($dataPost['manager']['id'])) {
                $ob->manager_project_id = $dataPost['manager']['id'];
            }
            if (!$ob->save()) {
                $message = $this->parserMessage($ob->getErrors());
                $error = true;
            } else {
                //add department
                if (isset($dataPost['departments']) && count($dataPost['departments'])) {
                    foreach ($dataPost['departments'] as $value) {
                        $proPa = new ProjectParticipant();
                        $proPa->project_id = $ob->id;
                        $proPa->owner_id = $value;
                        $proPa->owner_table = ProjectParticipant::TABLE_DEPARTMENT;
                        
                        if (!$proPa->save()) {
                            throw new \Exception('Save record to table ProjectParticipant fail');
                        }
                    }
                }
                //add member
                if (isset($dataPost['members']) && count($dataPost['members'])) {
                    foreach ($dataPost['members'] as $item) {
                        $proPa = new ProjectParticipant();
                        $proPa->project_id = $ob->id;
                        $proPa->owner_id = $item['id'];
                        $proPa->owner_table = ProjectParticipant::TABLE_EMPLOYEE;
                        
                        if (!$proPa->save()) {
                            throw new \Exception('Save record to table ProjectParticipant fail');
                        }
                    }
                }
                
                //move file
                File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $ob->id, File::TABLE_PROJECT);

                //activity
                $activity = new Activity();
                $activity->owner_id = $ob->id;
                $activity->owner_table = Activity::TABLE_PROJECT;
                $activity->parent_employee_id = 0;
                $activity->employee_id = \Yii::$app->user->getId();
                $activity->type = Activity::TYPE_CREATE_PROJECT;
                $activity->content = \Yii::$app->user->getIdentity()->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name;

                if (!$activity->save()) {
                    throw new \Exception('Save record to table Activity fail');
                }

                //Employee activity
                $employeeActivity = EmployeeActivity::find()->andCompanyId()->andWhere(['employee_id' => \Yii::$app->user->getId()])->one();
                if (!$employeeActivity) {
                    $employeeActivity = new EmployeeActivity();
                    $employeeActivity->employee_id = \Yii::$app->user->getId();
                    $employeeActivity->activity_project = $employeeActivity->activity_total = 0;
                }

                $employeeActivity->activity_project += 1;
                $employeeActivity->activity_total += 1;
                if (!$employeeActivity->save()) {
                    throw new \Exception('Save record to table EmployeeActivity fail');
                }
                //notifycation
                $arrayEmployees = [];
                $isQuery = false;
                $query = Employee::find();
                
                if (isset($dataPost['members']) && count($dataPost['members']) && isset($dataPost['departments']) && count($dataPost['departments'])) {
                    $isQuery = true;
                    $idEmployees = [];
                    foreach ($dataPost['members'] as $item) {
                        $idEmployees[] = $item['id'];
                    }
                    $query->andWhere('id in ('. implode(',', $idEmployees).') or department_id in ('.implode(',', $dataPost['departments']).')');
                } elseif (isset($dataPost['members']) && count($dataPost['members'])) {
                    $isQuery = true;
                    $idEmployees = [];
                    foreach ($dataPost['members'] as $item) {
                        $idEmployees[] = $item['id'];
                    }
                    $query->andWhere(['id' => $idEmployees]);
                } elseif (isset($dataPost['departments']) && count($dataPost['departments'])) {
                    $isQuery = true;
                    $query->andWhere(['department_id' => $dataPost['departments']]);
                }
                
                if ($isQuery) {
                    $content = \Yii::$app->user->getIdentity()->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name;
                    $arrayEmployees = $query->andCompanyId()->all();
                    $dataSend = [
                        '{creator name}' => \Yii::$app->user->getIdentity()->firstname,
                        '{project name}' => $ob->name
                    ];
                    
                    $themeEmail = \common\models\EmailTemplate::getThemeCreateProject();
                    $themeSms = \common\models\SmsTemplate::getThemeCreateProject();
                    
                    foreach ($arrayEmployees as $item) {
                        $no = new Notification();
                        $no->owner_id = $ob->id;
                        $no->owner_table = Notification::TABLE_PROJECT;
                        $no->employee_id = $item->id;
                        $no->owner_employee_id = \Yii::$app->user->getId();
                        $no->type = "create_project";
                        $no->content = $content;
                        
                        if (!$no->save()) {
                            throw new \Exception('Save record to table Notification fail');
                        }
                        
                        //send email 
                        $item->sendMail($dataSend, $themeEmail);
                        
                        $projEmployee[] = [
                            'project_id'  => $ob->id,
                            'employee_id' => $item->id,
                        ];
                        
                        //send sms
                        if ($ob->sms) {
                            $item->sendSms($dataSend, $themeSms);
                            $sms = new \common\models\Sms();
                            $sms->owner_id = $ob->id;
                            $sms->employee_id = $item->id;
                            $sms->owner_table = \common\models\Sms::TABLE_PROJECT;
                            $sms->content = $content;
                            $sms->is_success = 1;
                            $sms->fee = 0;
                            
                            if (!$sms->save()) {
                                throw new \Exception('Save record to table Sms fail');
                            }
                        }
                    }
                    
                    if (!empty($projEmployee)) {
                        if (!\Yii::$app->db->createCommand()->batchInsert(ProjectEmployee::tableName(), array_keys($projEmployee[0]), $projEmployee)->execute()) {
                            throw new \Exception('Save record to table project employee fail');
                        }
                    }
                }
            }
            
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            $error = true;
            $message = \Yii::t('member', 'error_system');
            return $this->sendResponse($error, $message, $objects);
        }

        return $this->sendResponse($error, $message, $objects);
    }

    /*
     * Function view project
     */
    public function actionView() {
        try {
            if ($projectId = \Yii::$app->request->post('projectId')) {
                if ($data_project = Project::getInfoProject($projectId)) {
                    $objects['collection'] = $data_project;
                    
                    //check authentication
                    //**check case is public
                    if (($data_project['project_info']['is_public'] == true) 
                         || (\Yii::$app->user->identity->is_admin == true)
                         || ($data_project['project_info']['manager_project_id'] == Yii::$app->user->identity->id)
                            ) {
                        return $this->sendResponse(false, $projectId, $objects);
                    } else {
                        $EmployeesInProject = ProjectEmployee::findOne([
                                'project_id'  => $projectId,
                                'company_id'  => $this->_companyId,
                                'employee_id' => Yii::$app->user->identity->id
                            ]);
                        if (!empty($EmployeesInProject)) {
                            return $this->sendResponse(false, $projectId, $objects);
                        }else {
                             Yii::$app->session->setFlash('errorViewProject', \Yii::t('member', "you do not have authoirity"));
                             $objects['collection']['error'] = true;
                             return $this->sendResponse(false, $projectId, $objects);
                        }
                    }
                }
            }
            throw new \Exception(\Yii::t('member', 'Can not get project info'));
        } catch (\Exception $e) {
            return $this->sendResponse(true, $e->getMessage(), []);
        }
    }

    /**
     * Edit project
    */
    public function actionEdit() {
        $objects = [];
        $dataPost = [];

        $projectJson = \Yii::$app->request->post('project', '');
        if (strlen($projectJson)) {
            $dataPost = json_decode($projectJson, true);
        }

        $transaction = \Yii::$app->db->beginTransaction();

        //create object and validate data
        try {
            //Check if get project is null value.
            if (!$ob = Project::findOne($dataPost['project_id'])) {
                throw new \Exception('Can not get Event');
            }

            $ob->attributes         = $dataPost;
            $ob->description_parse  = $ob->description;
            $ob->start_datetime     = $ob->start_datetime ? strtotime($ob->start_datetime) : null;
            $ob->duedatetime        = $ob->duedatetime ? strtotime($ob->duedatetime) : null;
            $ob->manager_project_id = $dataPost['manager']['id'];

            if (!$ob->save()) {
                $this->_message = $this->parserMessage($ob->getErrors());
                $this->_error = true;
                throw new \Exception($this->_message);
            }
            
            //add department
            $dataUpdate        = ['notification', 'sms', 'projectParticipant'];
            $updateParticipant = $this->_updataProjectParticipant($dataPost);
            $dataReplace       = $dataPost;
            $dataReplace['department_employess'] = $updateParticipant;

            //move file
            $listFile = File::addFiles($_FILES, \Yii::$app->params['PathUpload'], $ob->id, File::TABLE_PROJECT);

            //notifycation
            $arrayEmployees = [];
            $isQuery = false;
            $query = Employee::find();

            if (isset($dataPost['default_department']) && count($dataPost['default_department'])) {
                $isQuery = true;
                $query->orWhere(['department_id' => $dataPost['default_department']]);
            }

            if (isset($dataPost['members']) && count($dataPost['members'])) {
                $isQuery = true;
                $employeeIds = [];

                foreach ($dataPost['members'] as $item) {
                    $employeeIds[] = $item['id'];
                }

                $query->orWhere(['id' => $employeeIds]);
            }

            if ($isQuery) {
                $content = \Yii::$app->user->identity->firstname . " " . \Yii::t('common', 'created') . " " . $ob->name;
                $arrayEmployees = $query->andCompanyId()->all();
                $dataSend = [
                    '{creator name}' => \Yii::$app->user->identity->firstname,
                    '{project name}' => $ob->name
                ];
            }

            $themeEmail = \common\models\EmailTemplate::getThemeEditProject();
            $themeSms = \common\models\SmsTemplate::getThemeEditProject();

            if (!empty($arrayEmployees)) {
                foreach ($arrayEmployees as $item) {
                    $dataUpdate['notification'][] = [
                        'owner_id'      => $ob->id,
                        'owner_table'   => Notification::TABLE_PROJECT,
                        'employee_id'   => $item->id,
                        'type'          => 'create_project',
                        'content'       => $content,
                        'owner_employee_id' => \Yii::$app->user->getId(),
                    ];

                    //send email
                    $item->sendMail($dataSend, $themeEmail);

                    //send sms
                    if ($ob->sms) {
                        $item->sendSms($dataSend, $themeSms);
                        $dataUpdate['sms'][] = [
                            'fee'         => 0,
                            'content'     => $content,
                            'owner_id'    => $ob->id,
                            'employee_id' => $item->id,
                            'owner_table' => \common\models\Sms::TABLE_PROJECT,
                            'is_success'  => ActiveRecord::VAL_TRUE,
                        ];
                    }
                    
                    $dataUpdate['project_employess'][] = [
                    	'project_id'  => $ob->id,
                    	'employee_id' => $item->id,
                    ];
                }
            }
            
            //loop file
            if (!empty($listFile)) {
                $fileName = '';
                foreach ($listFile as $key => $file) {
                    $fileName .= '<div class="padding-left-20"><i><a href="' . \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $file['path'] . '">' . $file['name'] . '</a></i></div>';
                }
                
                $dataReplace['fileList'] = $fileName;
            }

            //Write log history for editing this project.
            if (($projectHistory = $this->_makeProjectHistory($dataReplace)) && !empty($projectHistory)) {
                //insert project_post table:
                $projectPost = new ProjectPost();
                $projectPost->project_id    = $ob->id;
                $projectPost->employee_id   = \Yii::$app->user->getId();
                $projectPost->parent_id     = 0;
                $projectPost->content       = $projectHistory;
                $projectPost->content_parse = $projectPost->content;
                $projectPost->parent_employee_id = 0;
                $projectPost->is_log_history = true;

                if (!$projectPost->save()) {
                    throw new \Exception('Save record to table project_post fail');
                }
            }
            
            if (!empty($dataUpdate['project_employess'])) {
	            if (!$this->_updateProjectEmployees($dataUpdate['project_employess'])) {
	                    throw new \Exception('Save record to table Notification fail');
	            }
            }

            if (!empty($dataUpdate['notification'])) {
                //insert batch table Notification
                if (!\Yii::$app->db->createCommand()->batchInsert(Notification::tableName(), array_keys($dataUpdate['notification'][0]), $dataUpdate['notification'])->execute()) {
                    throw new \Exception('Save record to table Notification fail');
                }
            }

            if (!empty($dataUpdate['sms'])) {
                //insert batch table sms
                if (!\Yii::$app->db->createCommand()->batchInsert(Sms::tableName(), array_keys($dataUpdate['sms'][0]), $dataUpdate['sms'])->execute()) {
                    throw new \Exception('Save record to table Sms fail');
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $this->_message = $e->getMessage();

            if (!$this->_error) {
                $this->_error = true;
                $this->_message = \Yii::t('member', 'error_system');
            }

            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, $objects);
        }

        return $this->sendResponse($this->_error, $this->_message, "");
    }

    /**
     * Make project history
     * 
     * @param array $dataPost 
     * @return string
     */
    private function _makeProjectHistory($dataPost) {
        $content = '';
        if (empty($dataPost)) {
            return $content;
        }

        $noSetting = \Yii::t('member', 'no setting');

        $dataReplace = array(
            \Yii::t('member', 'project name op')        => array($dataPost['projectInfo_old']['project_name'] => $dataPost['name']),
            \Yii::t('member', 'project start op')       => array(!empty($dataPost['projectInfo_old']['start_datetime']) ? date('d-m-Y', strtotime($dataPost['projectInfo_old']['start_datetime'])) : $noSetting => !empty($dataPost['start_datetime']) ? date('d-m-Y', strtotime($dataPost['start_datetime'])) : $noSetting),
            \Yii::t('member', 'project end op')         => array(!empty($dataPost['projectInfo_old']['duedatetime']) ? date('d-m-Y', strtotime($dataPost['projectInfo_old']['duedatetime'])) : $noSetting => !empty($dataPost['duedatetime']) ? date('d-m-Y', strtotime($dataPost['duedatetime'])) : $noSetting),
            \Yii::t('member', 'project priority op')    => array($dataPost['projectInfo_old']['priority_name'] => Priority::getPriorityName($dataPost['priority_id'])->name),
            \Yii::t('member', 'project share')          => array(empty($dataPost['projectInfo_old']['is_public']) ? $noSetting : \Yii::t('member', 'project share') => empty($dataPost['is_public']) ? $noSetting : \Yii::t('member', 'project share')),
            \Yii::t('member', 'project status op')      => array($dataPost['projectInfo_old']['status_name'] => Status::getStatusName($dataPost['status_id'])->name),
            \Yii::t('member', 'project description op') => array($dataPost['projectInfo_old']['description'] => $dataPost['description']),
            \Yii::t('member', 'project completed percent') => array($dataPost['projectInfo_old']['completed_percent']."%" => $dataPost['completed_percent']."%"),
            \Yii::t('member', 'project estimate op')    => array($dataPost['projectInfo_old']['estimate_hour'] => $dataPost['estimate_hour']),
            \Yii::t('member', 'project manager op')     => array(empty($dataPost['projectInfo_old']['manager_project_id']) ? $noSetting : '<a href="#/member/' . $dataPost['projectInfo_old']['manager_project_id'] . '">' . $dataPost['projectInfo_old']['project_manager'] . '</a>' => !empty($dataPost['manager']['id']) ?  '<a href="#/member/' . $dataPost['manager']['id'] . '">' . $dataPost['manager']['firstname'] . '</a>' : $noSetting),
        );

        //Create log project history text.
        foreach ($dataReplace as $key => $value) {
            if (!empty($value)) {
                $content .= "";
                foreach ($value as $after => $befor) {
                    if ($after != $befor) {
                        switch ($key) {
                            case \Yii::t('member', 'project description op'):
                            $description = !empty($befor) ? \Yii::t('member', 'project description op'). ' '. \Yii::t('member', 'comment update after') : $noSetting;
                            $content .= '<li>'. $description .'</li>';
                            break;
                            case \Yii::t('member', 'project status op'):
                            case \Yii::t('member', 'project priority op'):
                                $content .= '<li>'.str_replace(array('{{title}}', '{{after}}', '{{befor}}'), array($key, $after, $befor), \Yii::t('member', 'message info content')) .'</li>';
                            break;
                            default:
                                $content .= '<li>'.str_replace(array('{{title}}', '{{after}}', '{{befor}}'), array($key, $after, $befor), \Yii::t('member', 'message info content')) .'</li>';
                            break;
                        }
                    }
                }
                
                $listFile = '';
                if (!empty($dataPost['fileList']) && $dataPost['fileList']) {
                    $listFile = '<li>'.\Yii::t('member', 'add file') . '<br/>' . $dataPost['fileList'] .'</li>';
                }

                $tplEmployess = $tmpDepartment = '';
                if (!empty($dataPost['department_employess'])) {
                    $employes = $dataPost['department_employess']['employee'];
                    if (!empty($employes)) {
                        if (!empty($employes['old']) || !empty($employes['new'])) {

                            $tplEmployess = '<li><div>' . \Yii::t('member', 'change employee') . '</div></li>';
                            $divOld = "";
                            if (!empty($employesOld)) {
                                foreach ($employesOld as $old) {
                                    $divOld .='<div class="padding-left-20"><a href="#/member/' . $old['id'] . '"><i>' . $old['firstname'] . '</i></a></div>';
                                }

                                $tplEmployess .= '<div class="padding-left-20">' . \Yii::t('member', 'delete') . $divOld . '</div>';
                            }

                            $employesNew = $employes['new'];
                            $divNew = "";
                            if (!empty($employesNew)) {
                                foreach ($employesNew as $new) {
                                    $divNew .='<div class="padding-left-20"><a href="#/member/' . $new['id'] . '"><i>' . $new['firstname'] . '</i></a></div>';
                                }

                                $tplEmployess .= '<div class="padding-left-20"> ' . \Yii::t('member', 'add new') . $divNew . '</div>';
                            }

                            $employesOld = $employes['old'];
                            $tplEmployess .='</div>';
                        }
                    }

                    $department = $dataPost['department_employess']['department'];
                    if (!empty($department)) {
                        if (!empty($department['old']) || !empty($department['new'])) {
                            $tmpDepartment = '<li><div>' . \Yii::t('member', 'change department') . '</div></li>';
                            $departmentOld = $department['old'];
                            if (!empty($departmentOld)) {
                                $divOld = "";
                                foreach ($departmentOld as $oldD) {
                                    $divOld .='<div class="padding-left-20"><i>' . $oldD . '</i></div>';
                                }
                                $tmpDepartment .= '<div class="padding-left-20"> ' . \Yii::t('member', 'delete') . $divOld . '</div>';
                            }

                            $departmentNew = $department['new'];
                            if (!empty($departmentNew)) {
                                $departments = Department::findAll(["id" => $departmentNew]);
                                $divNew = "";
                                foreach ($departments as $newD) {
                                    $divNew .='<div class="padding-left-20"><i>' . $newD->name . '</i></div>';
                                }
                                
                                $tmpDepartment .= '<div class="padding-left-20"> ' . \Yii::t('member', 'add new') . $divNew . '</div>';
                            }
                            
                            $tmpDepartment .='</div>';
                        }
                    }
                }
            }
        }

        return $content . $tplEmployess . $tmpDepartment . $listFile == '' ? false : "<ul>". $content . $tmpDepartment . $tplEmployess . $listFile."</ul>";
    }

    /**
     * Function update or add info in table project_participant of screen edit project
     * 
     * @param array $dataPost data get from employee.
     * @return array
     */
    private function _updataProjectParticipant($dataPost = []) {
        $result = '';
        if (empty($dataPost)) {
            return false;
        }

        if (!empty($dataPost['departments_old']) && !empty($dataPost['default_department'])) {
            foreach ($dataPost['departments_old'] as $keyDepartmentOld => $val_departments_old) {
                foreach ($dataPost['default_department'] as $keyDepartmentNew => $valDepartmentNew) {
                    if ($keyDepartmentOld == $valDepartmentNew) {
                        unset($dataPost['departments_old'][$keyDepartmentOld]);
                        unset($dataPost['default_department'][$keyDepartmentNew]);
                    }
                }
            }
        }

        //delete department
        if (!empty($dataPost['departments_old'])) {
            ProjectParticipant::deleteAll([
                'owner_id' => array_keys($dataPost['departments_old']), //array_keys($dataPost['departments_old']),
                'project_id' => $dataPost['project_id'], //$dataPost['project_id'],
                'company_id' => $this->_companyId,
                'owner_table' => ProjectParticipant::TABLE_DEPARTMENT,
            ]);
        }

        //add new department project_participant
        if (!empty($dataPost['default_department'])) {
            $projDepartment = [];
            foreach ($dataPost['default_department'] as $owner_id) {
                $projDepartment[] = [
                    'project_id' => $dataPost['project_id'],
                    'owner_id' => $owner_id,
                    'owner_table' => ProjectParticipant::TABLE_DEPARTMENT,
                ];
            }
        }

        if (!empty($projDepartment)) {
            if (!\Yii::$app->db->createCommand()->batchInsert(ProjectParticipant::tableName(), array_keys($projDepartment[0]), $projDepartment)->execute()) {
                throw new \Exception('Save record to table Project Participant fail');
            }
        }

        $result['department']['old'] = $dataPost['departments_old'];
        $result['department']['new'] = $dataPost['default_department'];

        //Add employee in table project_participant
        if (!empty($dataPost['employess_old']) && !empty($dataPost['members'])) {
            foreach ($dataPost['employess_old'] as $keyEmployessOld => $valEmployeeOld) {
                foreach ($dataPost['members'] as $keyMemberNew => $valMemberNew) {
                    if ($valEmployeeOld['id'] == $valMemberNew['id']) {
                        unset($dataPost['employess_old'][$keyEmployessOld]);
                        unset($dataPost['members'][$keyMemberNew]);
                    }
                }
            }
        }

        //Delete employee
        if (!empty($dataPost['employess_old'])) {
            $employessOldDel = [];
            foreach ($dataPost['employess_old'] as $varEmployessOld) {
                $employessOldDel[] = $varEmployessOld['id'];
            }
                
            ProjectParticipant::deleteAll([
                'owner_id' => $employessOldDel,
                'project_id' => $dataPost['project_id'],
                'company_id' => $this->_companyId,
                'owner_table' => ProjectParticipant::TABLE_EMPLOYEE,
            ]);
        }

        //Add new department
        if (!empty($dataPost['members'])) {
            $projEmployee = [];
            foreach ($dataPost['members'] as $varEmployess) {
                $projEmployee[] = [
                    'project_id' => $dataPost['project_id'],
                    'owner_id' => $varEmployess['id'],
                    'owner_table' => ProjectParticipant::TABLE_EMPLOYEE,
                ];
            }
        }

        if (!empty($projEmployee)) {
            if (!\Yii::$app->db->createCommand()->batchInsert(ProjectParticipant::tableName(), array_keys($projEmployee[0]), $projEmployee)->execute()) {
                throw new \Exception('Save record to table Project Participant fail');
            }
        }

        $result['employee']['old'] = $dataPost['employess_old'];
        $result['employee']['new'] = $dataPost['members'];

        return $result;
    }
    
    /**
     * Update data inside table project employess
     * @param unknown_type $data content list data employess of employee and lisf employee to department
     * return boolean
     */
    private function _updateProjectEmployees($data = []) {
    	$result = true;
    	if (!empty($data)) {
    		$projectEmployeeOld = ProjectEmployee::findAll(["project_id" => $data[0]['project_id'], "company_id" => $this->_companyId]);
    		if (!empty($projectEmployeeOld)) {
    			$dataDelete = [];
    			foreach ($projectEmployeeOld AS $projectEmployeeOldKey => $projectEmployeeOldVal) {
    				$dataDelete[$projectEmployeeOldKey] = $projectEmployeeOldVal->id;
    				foreach ($data AS $datakey => $dataVal) {
    					if ($projectEmployeeOldVal->employee_id == $dataVal['employee_id']) {
    						unset($projectEmployeeOld[$datakey]);
    						unset($data[$datakey]);
    						unset($dataDelete[$projectEmployeeOldKey]);
    					}
    				}
    			}
    			
    			if (!empty($dataDelete)) {
    				if (!ProjectEmployee::deleteAll(['id' => $dataDelete])) {
    					$result = false;
    				}
    			}
    		}
    		
    		if (!empty($data)) {
    			if (!\Yii::$app->db->createCommand()->batchInsert(ProjectEmployee::tableName(), array_keys($data[0]), $data)->execute()) {
    				$result = false;
    			}
    		}
    	}
    	return $result;
    }

}
