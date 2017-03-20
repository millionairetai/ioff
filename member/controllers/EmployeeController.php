<?php

namespace member\controllers;

use Yii;
use common\components\web\StatusMessage;
use common\models\Employee;
use common\models\Project;
use common\models\EmailTemplate;
use yii\validators\EmailValidator;
use common\models\Status;
use common\models\ProjectEmployee;
use member\models\ChangePasswordForm;
use common\models\File;
use yii\validators\ImageValidator;
use common\models\Activity;
use common\models\Company;

class EmployeeController extends ApiController {

    // Get all calendar id from array
    public function actionSearch() {
        $objects = [];
        $keyword = Yii::$app->request->post('keyword');
        $departments = Yii::$app->request->post('departments', []);
        $members = Yii::$app->request->post('members', []);
        $manager = Yii::$app->request->post('manager', []);
        $employees = Employee::getEmployeeByParams($keyword, $members, $departments, $manager);
        if (!empty($employees)) {
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

    public function actionSearchByProjectIdAndKeyword() {
        $error = false;
        $message = "";
        $objects = [];
        $collection = [];
        $keyword = Yii::$app->request->post('keyword');
        if ($employees = ProjectEmployee::getEmployeesByProjectId(Yii::$app->request->post('project_id'))) {
            foreach ($employees as $employee) {
                if ($keyword == '' || strpos($employee->fullname, $keyword) === 0) {
                    $collection[] = [
                        'id' => $employee->id,
                        'fullname' => $employee->fullname,
                        'email' => $employee->email,
                        'image' => $employee->getImage()
                    ];
                }
            }     
        } else {
            $error = true;
            $message = Yii::t('member', 'Do not has any employees in this project');
        }
        
        $objects['collection'] = $collection;
        return $this->sendResponse($error, $message, $objects);
    }
    
    public function actionSearchByKeyword() {
        $keyword = Yii::$app->request->post('keyword');
        $employees = Employee::find()->andCompanyId()->all();
        
        $error = false;
        $message = "";
        $objects = [];
        $collection = [];
        
        foreach ($employees as $employee) {
            if ($keyword == '' || strpos($employee->firstname, $keyword) === 0) {
                $collection[] = [
                    'id' => $employee->id,
                    'firstname' => $employee->firstname,
                    'email' => $employee->email,
                    'image' => $employee->getImage()
                ];
            }
        }
                        
        $objects['collection'] = $collection;
                                
        return $this->sendResponse($error, $message, $objects);
    }    

    //Get all employees by status
    public function actionGetEmployees() {
        $objects = [];
        $itemPerPage = \Yii::$app->request->get('limit');
        $currentPage = \Yii::$app->request->get('page');
        $searchName = \Yii::$app->request->get('searchName');
        $statusName = Yii::$app->request->get('statusName', []);
        $employees = Employee::getEmployeesByStatusName($statusName, $searchName, $itemPerPage, $currentPage);
        if (!empty($employees['employee'])) {
            foreach ($employees['employee'] as $employee) {
                $objects['employees'][] = [
                    'id' => $employee->id,
                    'fullname' => $employee->fullname,
                    'email' => $employee->email,
                    'image' => $employee->image,
                    'is_admin' => (boolean)$employee->is_admin,
                    'department' => !empty($employee->department->name) ? $employee->department->name : '',
                    'status' => !empty($employee->status->name) ? $employee->status->name : '',
                ];
            }
        }

        $objects['totalItems'] = (int) $employees['totalCount'];
        return $this->sendResponse(false, "", $objects);
    }

    //Get all employees by status
    public function actionInvite() {
        $objects = [];
        $message = \Yii::$app->request->post('message');
        $emails = \Yii::$app->request->post('emails');
        $this->_message = 'Email %s is invalid';
        try {
            //Check max employee with current employee total. If over max employee, we aren't allowed to add new.
            $company = Company::getById(Yii::$app->user->identity->company_id, [], false);
            if ($company['max_user_register'] != 0 && ($company['max_user_register'] - $company['total_employee']) < count($emails)) {
                $this->_message = Yii::t('member', 'Total employee can not be more than max of employee package. Please upgrade your package to add new employee');
                throw new \Exception($this->_message);
            }
            
            //Check valid if that's email
            $error = null;
            $validator = new EmailValidator();
            foreach ($emails as $key => $email) {
                $emails[$key] = trim($email);
                if (!$validator->validate($emails[$key], $error)) {
                    $this->_message = sprintf($this->_message, $email);
                    throw new \Exception($this->_message);
                }
            }

            //Check whether emails is existed.
            if ($existedEmail = Employee::getExistedEmailByEmails($emails)) {
                $this->_message = Yii::t('member', 'Email %s is existed');
                $this->_message = sprintf($this->_message, implode(', ', array_values($existedEmail)));
                throw new \Exception($this->_message);
            }

            //Send email
            $themeEmail = EmailTemplate::getTheme(EmailTemplate::INVITE_NEW_EMPLOYEE);
            $dataSend = [
                '{inviter}' => \Yii::$app->user->identity->fullname,
                '{urlConfirm}' => '',
                '{message}' => $message
            ];

            if (!$status = Status::getByOwnerTableAndColumnName('employee', Employee::COLUNM_NAME_INVITED)) {
                $this->_message = 'Can not invite new employee';
                throw new \Exception($this->_message);
            }

            $employee = new Employee();
            $employees = [];
            foreach ($emails as $email) {
                $token = md5(uniqid() . $email);
                $dataSend['{urlConfirm}'] = SITE_URL . "index/register?email={$email}&token={$token}";
                $employee->email = $email;
                $employees[] = [
                    'email' => $email,
                    'firstname' => '',
                    'lastname' => '',
                    'password' => '',
                    'status_id' => $status['id'],
                    'password_reset_token' => $token,
                ];

                if (!$employee->sendMail($dataSend, $themeEmail)) {
                    $this->_message = Yii::t('member', 'Can not send email to') . $email;
                    throw new \Exception($this->_message);
                }
            }

            //Insert batch new invited employee
            if (!Employee::batchInsert($employees)) {
                $this->_message = 'Invite new employees fail ';
                throw new \Exception($this->_message);
            }
            
            //Increase total employee up.
            if (!Company::updateAllCounters(['total_employee' => count($emails)], ['id' => Yii::$app->user->identity->company_id])) {
                $this->_message = Yii::t('member', 'error_system');
                throw new \Exception($this->_message);
            }            
        } catch (\Exception $e) {
            return $this->sendResponse(true, $e->getMessage(), []);
        }

        return $this->sendResponse(false, "", $objects);
    }

    //Get an employee
    public function actionGet($id) {
        $employee = Employee::getById($id, [
            'id',
            'department_id',
            'authority_id',
            'status_id', 
            'firstname',
            'lastname',
            'email',
            'is_admin',
            'birthdate',
            'gender',
            'mobile_phone',
            'work_phone'
        ], false);
        
        if ($employee) {
            $employee['is_admin'] = (boolean)$employee['is_admin'];
            $employee['birthdate'] = !empty($employee['birthdate']) ? \Yii::$app->formatter->asDate($employee['birthdate']) : '';
            return $this->sendResponse(false, "", $employee);
        }
        
        return $this->sendResponse(false, "", []);
    }
    
    //Update an employee
    public function actionUpdate() {
        try {
            if ($employee = Employee::getById(Yii::$app->request->post('id'))) {
                $employee->attributes = Yii::$app->request->post();
                $employee->birthdate = $employee->birthdate != 0 ?  strtotime($employee->birthdate) : $employee->birthdate;
                if ($employee->save() !== false) {
                    return $this->sendResponse($this->_error, $this->_message, []);
                }
                
                $this->_message = $this->parserMessage($employee->getErrors());
            }
            
            throw new \Exception($this->_message);
        } catch (\Exception $ex) {
            $this->_error = true;
            return $this->sendResponse($this->_error, $this->_message, []);
        }
       
        return $this->sendResponse(false, "", $employee);
    }
    
    //Add an employee
    public function actionAdd() {
        try {
            $transaction = \Yii::$app->db->beginTransaction();
            //Check max employee with current employee total. If over max employee, we aren't allowed to add new.
            $company = Company::getById(Yii::$app->user->identity->company_id, [], false);
            if ($company['max_user_register'] != 0 && $company['total_employee'] >= $company['max_user_register']) {
                $this->_message = Yii::t('member', 'Total employee can not be more than max of employe package. Please upgrade your package to add new employee');
                throw new \Exception('Total employee can not be more than max of employe package.');
            }
            
            if ($employee = new Employee()) {
                $employee->attributes = Yii::$app->request->post();
                $employee->birthdate = $employee->birthdate != 0 ?  strtotime($employee->birthdate) : $employee->birthdate;;
                if (empty($employee->password)) {
                    $employee->password = Yii::$app->security->generateRandomString(6);
                }
                
                if ($employee->validate()) {
                    $dataSend = [
                        '{employee name}' => $employee->fullname,
                        '{account}' => $employee->email,
                        '{password}' => $employee->password
                    ];
                    
                    $employee->setPassword($employee->password);
                    $employee->generateAuthKey();
                    if ($employee->save() !== false) {
                        //Save activity
                       //update table activity
                        $activity = new Activity();
                        $activity->owner_id = $employee->id;
                        $activity->owner_table = Activity::TABLE_EMPLOYEE;
                        $activity->parent_employee_id = 0;
                        $activity->employee_id = \Yii::$app->user->getId();
                        $activity->type = Activity::TYPE_ADD_ACCOUNT;
                        $activity->content = '';
                        if ($activity->save() === false) {
                            throw new \Exception('Save record to table Activity fail');
                        }
                    }
                    
                    //Increase total employee one step up.
                    if (!Company::updateAllCounters(['total_employee' => 1], ['id' => Yii::$app->user->identity->company_id])) {
                        $this->_message = Yii::t('member', 'error_system');
                        throw new \Exception('Can not increase total employee up');
                    }
                    
                    //Send email to that employee to annouce.
                    $employee->sendMail($dataSend, EmailTemplate::getTheme(EmailTemplate::SUCCESS_EMPLOYEE_REGISTRATION));
                    $transaction->commit();
                    return $this->sendResponse($this->_error, $this->_message, []);
                }
                
                $this->_message = $this->parserMessage($employee->getErrors());
            }
            
            throw new \Exception($this->_message);
        } catch (\Exception $ex) {
            $transaction->rollBack();
            $this->_error = true;
            return $this->sendResponse($this->_error, $this->_message, []);
        }
       
        return $this->sendResponse(false, "", $employee);
    }
    
    //Get an employee
    public function actionGetProfile($employeeId) {
        $profile = [];
        try {
            if ($employee = Employee::getById($employeeId)) {
                //Check condition to get info.
                $profile =[
                    'id'=> $employee->id,
                    'department_id' => $employee->department_id,
                    'department' => !empty($employee->department->name) ? $employee->department->name : '',
//                    'authority_id',
                    'status' => !empty($employee->status->name) ? $employee->status->name : '',
                    'fullname' => $employee->fullname,
                    'firstname' => $employee->firstname,
                    'lastname' => $employee->lastname,
                    'email' => $employee->email,
                    'is_admin' => $employee->is_admin,
                    'birthdate' => $employee->birthdate,
                    'mobile_phone' => $employee->mobile_phone,
                    'work_phone' => $employee->work_phone,
                    'image' => $employee->image,
                    'birthdate' => (!empty($employee->birthdate) ? \Yii::$app->formatter->asDate($employee->birthdate) : ''),
                    'birthdate_edit' => (!empty($employee->birthdate) ? \Yii::$app->formatter->asDate($employee->birthdate, 'php:Y-m-d') : ''),
//                    'gender' => $employee->gender,
                    'street_address_1' => $employee->street_address_1,
                    'loginEmployeeId' => Yii::$app->user->identity->id
                ];
            } else {
                throw new \Exception($this->_message);
            }
        } catch (\Exception $ex) {
            $this->_error = true;
            return $this->sendResponse($this->_error, $this->_message, []);
        }
       
        return $this->sendResponse(false, "", $profile);
    }
    
    //Update an employee
    public function actionUpdateProfile() {
        try {
            if ($employee = Employee::getById(Yii::$app->request->post('id'))) {
                $employee->attributes = Yii::$app->request->post();
                $employee->birthdate = ($employee->birthdate != 0 && $employee->birthdate != '') ?  strtotime($employee->birthdate) : 0;
                if ($employee->save() !== false) {
                    $profile = [
                        'id' => $employee->id,
                        'department_id' => $employee->department_id,
                        'department' => !empty($employee->department->name) ? $employee->department->name : '',
                        'status' => !empty($employee->status->name) ? $employee->status->name : '',
                        'fullname' => $employee->fullname,
                        'firstname' => $employee->firstname,
                        'lastname' => $employee->lastname,
                        'email' => $employee->email,
                        'is_admin' => $employee->is_admin,
                        'mobile_phone' => $employee->mobile_phone,
                        'work_phone' => $employee->work_phone,
                        'image' => $employee->image,
                        'birthdate' => (!empty($employee->birthdate) ? \Yii::$app->formatter->asDate($employee->birthdate) : ''),
                        'birthdate_edit' => (!empty($employee->birthdate) ? \Yii::$app->formatter->asDate($employee->birthdate, 'php:Y-m-d') : ''),
    //                    'gender' => $employee->gender,
                        'street_address_1' => $employee->street_address_1,
                    ];
                    return $this->sendResponse($this->_error, $this->_message, $profile);
                }
                
                $this->_message = $this->parserMessage($employee->getErrors());
            }
            
            throw new \Exception($this->_message);
        } catch (\Exception $ex) {
            $this->_error = true;
            $this->_message = $ex->getMessage();
            return $this->sendResponse($this->_error, $this->_message, []);
        }
       
        return $this->sendResponse(false, "", $employee);
    }
    
    //Change password an employee
    public function actionChangePassword() {
        try {
            $model = new ChangePasswordForm();
            $model->attributes = Yii::$app->request->post();
            if ($model->changePassword(Yii::$app->request->post('id'))) {
                return $this->sendResponse(false, "", []);
            } else {
                $this->_message = $this->parserMessage($model->getErrors());
            }
            throw new \Exception($this->_message);
        } catch (\Exception $ex) {
            $this->_error = true;
            $this->_message = $ex->getMessage();
            return $this->sendResponse($this->_error, $this->_message, []);
        }
       
        return $this->sendResponse(false, "", []);
    }
    
    //Change password an employee
    public function actionChangeAvatar() {
        try {
            $file = current($_FILES);
            if (empty($file)) {
                throw new \Exception(Yii::t('member', 'You must select at least one jpeg, gif, png image file'));
            }
            
            if(!in_array($file['type'], ['image/jpeg', 'image/pjpeg', 'image/gif', 'image/png']) ) {
                throw new \Exception(Yii::t('member', 'Only accept jpeg, gif, png image'));
            }
            
            $file = File::changeAvatar($file);
            if ($file === false) {
                $this->_message = Yii::t('common', 'Can not upload data');
                throw new \Exception($this->_message);
            }
        } catch (\Exception $ex) {
            $this->_error = true;
            $this->_message = Yii::t('common', 'Can not upload data');
            return $this->sendResponse($this->_error, $this->_message, []);
        }
       
        return $this->sendResponse(false, "", ['image' => $file->image]);
    }
}