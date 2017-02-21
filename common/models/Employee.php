<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use common\components\db\ActiveRecord;

/**
 * This is the model class for table "employee".
 *
 * @property string $id
 * @property string $company_id
 * @property string $manager_employee_id
 * @property integer $authority_id
 * @property string $position_id
 * @property integer $department_id
 * @property string $bank_id
 * @property string $religion_id
 * @property string $marriage_status_id
 * @property string $nation_id
 * @property string $province_id
 * @property string $country_id
 * @property integer $status_id
 * @property string $language_id
 * @property string $city_code
 * @property string $firstname
 * @property string $lastname
 * @property string $password
 * @property string $email
 * @property integer $is_admin
 * @property string $code
 * @property string $card_number
 * @property string $birthdate
 * @property integer $gender
 * @property string $street_address_1
 * @property string $street_address_2
 * @property string $telephone
 * @property string $mobile_phone
 * @property string $work_phone
 * @property string $card_place_id
 * @property string $work_email
 * @property string $card_number_id
 * @property string $card_issue_id
 * @property string $bank_number
 * @property string $passport_number
 * @property string $passport_place
 * @property string $passport_expire
 * @property string $zip_code
 * @property string $passport_issue
 * @property string $tax_date_issue
 * @property string $tax_code
 * @property string $tax_department
 * @property string $start_working_date
 * @property string $stop_working_date
 * @property integer $is_visible
 * @property string $profile_image_path
 * @property string $language_code
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $last_activity_datetime
 * @property string $last_ip_address
 * @property string $last_login_datetime
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property integer $disabled
 */
class Employee extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 20;
    //Change with database.
    const STATUS_ACTIVE = 10;
    //Status of employee.
    const COLUNM_NAME_ACTIVE = 'employee.active';
    const COLUNM_NAME_INACTIVE = 'employee.inactive';
    const COLUNM_NAME_INVITED = 'employee.invited';
//    const COLUNM_NAME_DISABLED = 'employee.disabled';

    //scenario employee
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'employee';
    }

    public static function primaryKey() {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_id', 'manager_employee_id', 'authority_id', 'position_id', 'department_id', 'bank_id', 'religion_id', 'marriage_status_id', 'nation_id', 'province_id', 'country_id', 'status_id', 'language_id', 'birthdate', 'card_issue_id', 'passport_expire', 'passport_issue', 'tax_date_issue', 'start_working_date', 'stop_working_date', 'last_activity_datetime', 'last_login_datetime', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['authority_id',  'status_id', 'firstname', 'lastname', 'email'], 'required'],
            [['city_code', 'firstname', 'lastname', 'email', 'work_email'], 'string', 'max' => 99],
            [['code', 'telephone', 'mobile_phone', 'work_phone', 'card_place_id'], 'string', 'max' => 50],
            [['card_number'], 'string', 'max' => 30],
            [['language_code'], 'string', 'max' => 10],
            [['street_address_1', 'street_address_2', 'passport_place', 'tax_department', 'profile_image_path', 'password_reset_token', 'last_ip_address'], 'string', 'max' => 255],
            [['card_number_id', 'bank_number', 'passport_number', 'zip_code', 'tax_code'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['email', 'work_email'], 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\Employee'],
            [['disabled', 'gender', 'is_admin'], 'boolean'],
            [['status_id'], 'default', 'value' => self::STATUS_ACTIVE],
            [['password'], 'required', 'on' => [self::SCENARIO_LOGIN, self::SCENARIO_REGISTER]],
            [['password'], 'string', 'length' => [6, 64]],
//            [['status_id'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
    
    public function fields() {
        $fields = parent::fields();
        // remove fields that contain sensitive information
        unset($fields['auth_key'], $fields['password'], $fields['password_reset_token']);
        
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => 'company_id',
            'manager_employee_id' => Yii::t('app', 'Manager Employee ID'),
            'authority_id' => Yii::t('app', 'Authority ID'),
            'position_id' => Yii::t('app', 'Position ID'),
            'department_id' => Yii::t('app', 'Department ID'),
            'bank_id' => Yii::t('app', 'Bank ID'),
            'religion_id' => Yii::t('app', 'Religion ID'),
            'marriage_status_id' => Yii::t('app', 'Marriage Status ID'),
            'nation_id' => Yii::t('app', 'Nation ID'),
            'province_id' => Yii::t('app', 'Province ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'status_id' => Yii::t('app', 'Status ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'city_code' => Yii::t('app', 'City Code'),
            'firstname' => Yii::t('common', 'First name'),
            'lastname' => Yii::t('common', 'Last name'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'is_admin' => Yii::t('app', 'Is Admin'),
            'code' => Yii::t('app', 'Code'),
            'card_number' => Yii::t('app', 'Card Number'),
            'birthdate' => Yii::t('app', 'Birthdate'),
            'gender' => Yii::t('app', 'Gender'),
            'street_address_1' => Yii::t('app', 'Street Address 1'),
            'street_address_2' => Yii::t('app', 'Street Address 2'),
            'telephone' => Yii::t('app', 'Telephone'),
            'mobile_phone' => Yii::t('app', 'Mobile Phone'),
            'work_phone' => Yii::t('app', 'Work Phone'),
            'card_place_id' => Yii::t('app', 'Card Place ID'),
            'work_email' => Yii::t('app', 'Work Email'),
            'card_number_id' => Yii::t('app', 'Card Number ID'),
            'card_issue_id' => Yii::t('app', 'Card Issue ID'),
            'bank_number' => Yii::t('app', 'Bank Number'),
            'passport_number' => Yii::t('app', 'Passport Number'),
            'passport_place' => Yii::t('app', 'Passport Place'),
            'passport_expire' => Yii::t('app', 'Passport Expire'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'passport_issue' => Yii::t('app', 'Passport Issue'),
            'tax_date_issue' => Yii::t('app', 'Tax Date Issue'),
            'tax_code' => Yii::t('app', 'Tax Code'),
            'tax_department' => Yii::t('app', 'Tax Department'),
            'start_working_date' => Yii::t('app', 'Start Working Date'),
            'stop_working_date' => Yii::t('app', 'Stop Working Date'),
            'is_visible' => Yii::t('app', 'Is Visible'),
            'profile_image_path' => Yii::t('app', 'Profile Image Path'),
            'language_code' => Yii::t('app', 'Language code'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'last_activity_datetime' => Yii::t('app', 'Last Activity Datetime'),
            'last_ip_address' => Yii::t('app', 'Last Ip Address'),
            'last_login_datetime' => Yii::t('app', 'Last Login Datetime'),
            'datetime_created' => Yii::t('app', 'Datetime Created'),
            'lastup_datetime' => Yii::t('app', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('app', 'Lastup Employee ID'),
            'disabled' => Yii::t('app', 'Disabled'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status_id' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getCompanyId() {
        return $this->company_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * Get image profile
     * 
     * @return string
     */
    public function getImage() {
        if ($this->profile_image_path) {
            return DIRECTORY_SEPARATOR .  'upload' . DIRECTORY_SEPARATOR . Yii::$app->user->identity->company_id . DIRECTORY_SEPARATOR . 'avatar'. DIRECTORY_SEPARATOR . $this->profile_image_path . '?time=' . time();
        }

        return DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'profileImageDefault.jpg';
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin() {
        return \Yii::$app->user->identity->is_admin == true;
    }

    /**
     * Get full name
     * @return string
     */
//    public function getFullName(){
//        return Yii::$app->user->identity->firstname .' '. Yii::$app->user->identity->lastname;
//    }

    /**
     * send email to employee
     * 
     * @param array $dataSend
     * @param array $themeEmail
     * 
     * @return boolen
     */
    public function sendMail($dataSend, $themeEmail) {
        if (!$themeEmail) {
            return false;
        }
        $body = $themeEmail->body;
        $subject = $themeEmail->subject;
        foreach ($dataSend as $key => $value) {
            $body = str_replace($key, $value, $body);
        }
//        header("content-type: text/html; charset=UTF-8");  
//        echo $body;die;
        /* \Yii::$app->mailer->compose()
          ->setFrom('from@domain.com')
          ->setTo($this->email)
          ->setSubject($subject)
          ->setTextBody($body)
          ->setHtmlBody($body)
          ->send(); */

        return true;
    }

    /**
     * send sms to employee
     */
    public function sendSms($dataSend, $themeSms) {
        if (!$themeSms) {
            return false;
        }
        $body = $themeSms->body;
        foreach ($dataSend as $key => $value) {
            $body = str_replace($key, $value, $body);
        }
    }

    /**
     * Update last_ip_address,last_login_datetime after login
     */
    public function updateEmployeeLoginInfo() {
        Yii::$app->user->identity->last_ip_address = Yii::$app->request->getUserIP();
        Yii::$app->user->identity->last_login_datetime = time();
        return Yii::$app->user->identity->update();
    }

    /**
     * Get employee fullName
     * 
     * @return string
     */
    public function getFullName() {
        return $this->firstname . ' ' . $this->lastname;
    }
        
    /**
     * Get employee fullName
     * 
     * @return string
     */
    public function getGender() {
        return $this->gender ? Yii::t('common', 'male') : Yii::t('common', 'female');
    }

//    public function getAssignedTasks() {
//        return $this->hasMany(Task::className(), ['id' => 'task_id'])->viaTable('task_assignment', ['employee_id' => 'id'])->joinWith(['company' => function($query) {
//                        $query->onCondition(Company::tableName() . '.id =' . \Yii::$app->user->getCompanyId());
//                    }]);
//    }

    public function getCompany() {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * Get department
     * 
     * @return object
     */
    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }
    
    /**
     * Get info of list employee
     * 
     * @param array $departments
     * @param array $employees
     * 
     * @return array
     */
    public static function getlistByepartmentIdsAndEmployeeIds($departments = [], $employees = []) {
        $result = [];
        $employeeIds = empty($employees) ? null : $employees;
        $departmentIds = empty($departments) ? null : $departments;
        //Get employee is actived.
        $employees = self::find()
                ->select([self::tableName() . '.id', 'firstname', 'lastname', 'profile_image_path', 'department_id', 'birthdate'])
                ->leftJoin(Status::tableName(), Status::tableName() . '.id=' . self::tableName() . '.status_id')
                ->andWhere([self::tableName() . '.id' => $employeeIds])
                ->orWhere(['department_id' => $departmentIds])
                ->andWhere(['column_name' => self::COLUNM_NAME_ACTIVE])
                ->andCompanyId(false, self::tableName())
                ->all();

        if (!empty($employees)) {
            $count = 0;
            foreach ($employees as $employee) {
                $result['employeeList'][] = [
                    'id' => $employee->id,
                    'firstname' => $employee->getFullName(),
                    'image' => $employee->getImage(),
                    'birthdate' => isset($employee->birthdate) ? date('Y-m-d', $employee->birthdate) : null,
                ];

                if (!empty($employeeIds) && in_array($employee->id, $employeeIds)) {
                    $result['employeeEditList'][] = [
                        'id' => $employee->id,
                        'firstname' => $employee->getFullName(),
                        'image' => $employee->getImage(),
                        'birthdate' => isset($employee->birthdate) ? date('Y-m-d', $employee->birthdate) : null,
                    ];
                }
                $result['count'] = ++$count;
            }
        }

        return $result;
    }

    /**
     * Get employee by keywords, department, manager, member
     * 
     * @param string $keyword
     * @param array $departments
     * @param array $manager
     * @param array $members
     * @return array|boolean
     */
    public function getEmployeeByParams($keyword = '', $members = [],  $departments = [], $manager = []) {
        $query = Employee::find()
                ->select([self::tableName() . '.id', 'email', 'firstname', 'lastname', 'profile_image_path'])
                ->joinWith('status')
                ->andWhere([Status::tableName() . ".column_name" => self::COLUNM_NAME_ACTIVE]);

        //check keyword
        if (!empty($keyword)) {
            $query->andWhere('CONCAT(employee.firstname, employee.lastname) LIKE :name', [':name' => '%' . $keyword . '%']);
        }

        //check department
        if (!empty($departments)) {
            $query->andWhere(['not in', 'department_id', $departments]);
        }

        //check manager
        if (!empty($manager['id'])) {
            $query->andWhere(['!=', self::tableName() . '.id', $manager['id']]);
        }

        //check member
        if (!empty($members)) {
            $ids = [];
            foreach ($members as $member) {
                $ids[] = $member['id'];
            }
            $query->andWhere(['not in', self::tableName() . '.id', $ids]);
        }
        
        return $query->andCompanyId(false, self::tableName())->all();
    }
    
    /**
     * Get status
     * @return object
     */
    public function getStatus() {
        return $this->hasOne(Status::className(), ['id' => 'status_id'])->select(['id', 'name']);
    }
    
    /**
     * Get employees by status name
     *
     * @param string $statusName
     * @return boolean|array
     */
    public static function getEmployeesByStatusName($statusName, $searchName, $itemPerPage, $currentPage = 1, $orderBy = 'datetime_created', $orderType = 'DESC') {
        $employee = Employee::find()
                ->select(['employee.id', 'email', 'firstname', 'lastname', 'profile_image_path', 'status_id', 'department_id', 'is_admin'])
                ->joinWith('status', 'department');

        if ($statusName) {
            $employee = $employee->where(["status.column_name" => 'employee.' . $statusName]);
        }

        if ($searchName) {
            $employee = $employee->andWhere('CONCAT(employee.firstname, employee.lastname) LIKE :name', [':name' => '%' . $searchName . '%']);
        }

        $employee = $employee->andCompanyId(false, 'employee')->limit($itemPerPage)->offset(($currentPage - 1) * $itemPerPage);
        
        return [
            'employee' => $employee->orderBy("employee.$orderBy $orderType")->all(),
            'totalCount' => (int) $employee->count(),
        ];
    }

    /**
     * Get employees by ids
     *
     * @param array $ids
     * @return boolean|array
     */
    public static function getByIds($ids = []) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        return self::find()->select([self::tableName() . '.id', self::tableName() . '.email', 'firstname', 'lastname'])
                ->where([self::tableName() . '.id' => $ids])
                ->andCompanyId()
                ->all();
    }

    /**
     * Get employees by emails
     *
     * @param array $emails
     * @return boolean|array
     */
    public static function getExistedEmailByEmails($emails) {
        $employees = self::find()
                ->select(['email'])
                ->where('email IN("' . implode('", "', $emails) . '")')
                ->asArray()
                ->all();

        $return = [];
        //Traverse
        foreach ($employees as $employee) {
            $return[] = $employee['email'];
        }

        return $return;
    }
    
    /**
     * Get inivited info of employee
     *
     * @param string $emails
     * @param string $token
     * @return boolean|array
     */
    public static function getInvitedInfo($email, $token) {
        if (empty($token)) {
            return false;
        }
        
        return self::find()
                ->select([Employee::tableName() . '.id', 'email', 'status_id', Employee::tableName() . '.company_id'])
                ->leftJoin(Status::tableName(), Employee::tableName() . '.status_id=' . Status::tableName() . '.id')
                ->where([
                    Employee::tableName() . '.email' => $email, 
                    Employee::tableName() . '.password_reset_token' => $token, 
                    Status::tableName() . '.column_name' => Employee::COLUNM_NAME_INVITED,                     
                ])
                ->one();
        
    }
    
    /**
     * Get employees by email
     *
     * @param array $emails
     * @return boolean|array
     */
    public static function getByEmail($email) {        
         return self::find()
                    ->select([Employee::tableName() . '.id', 'email'])
                    ->where([
                        Employee::tableName() . '.email' => $email, 
                    ])
                    ->one();
        
    }
    
    /**
     * Get Employeee Id by department Id and employee Id
     * 
     * @param array $departmentIds
     * @param array $employeeIds
     * 
     * @return array - array of employee id
     */
    public static function getEmployeeIdByDepartmentIdAndEmployeeId($departmentIds = [], $employeeIds = []) {
        $result = [];
        $employeeIds = empty($employeeIds) ? null : $employeeIds;
        $departmentIds = empty($departmentIds) ? null : $departmentIds;
        //Get employee is actived.
        $employees = self::find()
                ->select([self::tableName() . '.id'])
//                ->leftJoin(Status::tableName(), Status::tableName() . '.id=' . self::tableName() . '.status_id')
                ->andWhere([self::tableName() . '.id' => $employeeIds])
                ->orWhere(['department_id' => $departmentIds])
//                ->andWhere(['column_name' => self::COLUNM_NAME_ACTIVE])
                ->andCompanyId()
                ->asArray()
                ->all();

        if (!empty($employees)) {
            foreach ($employees as $employee) {
                $result[] = $employee['id'];
            }
        }

        return $result;
    }
    
    /**
     * Get employees by ids and index array by id
     * @param array $ids
     * @return array
     */
    public static function getsIndexByIdByIds($ids) {
        return self::find()->select(['id', 'firstname', 'lastname', 'profile_image_path', 'email'])
                ->where([ 'id' => $ids])
                ->indexBy('id')
                ->asArray()
                ->all();
    }
    
    /**
     * Get toal employee
     * @return integer
     */
    public static function getTotalEmployee() {
        return self::find()->select('*')->count();
    }    
}
