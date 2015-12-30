<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use common\components\db\CeActivieRecord;

/**
 * This is the model class for table "employee".
 *
 * @property string $id
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
 * @property string $city_code
 * @property string $firstname
 * @property string $lastname
 * @property string $username
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
 * @property integer $is_visible
 * @property string $profile_image_path
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
class Employee extends CeActivieRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_employee_id', 'authority_id', 'position_id', 'department_id', 'bank_id', 'religion_id', 'marriage_status_id', 'nation_id', 'province_id', 'country_id', 'status_id', 'is_admin', 'birthdate', 'gender', 'card_issue_id', 'passport_expire', 'passport_issue', 'tax_date_issue', 'start_working_date', 'is_visible', 'last_activity_datetime', 'last_login_datetime', 'datetime_created', 'lastup_datetime', 'lastup_employee_id', 'disabled'], 'integer'],
            [['authority_id', 'position_id', 'department_id', 'bank_id', 'religion_id', 'marriage_status_id', 'nation_id', 'province_id', 'country_id', 'status_id', 'firstname', 'lastname', 'username', 'password', 'email', 'birthdate'], 'required'],
            [['city_code', 'firstname', 'lastname', 'email', 'work_email'], 'string', 'max' => 99],
            [['username'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 64],
            [['code', 'telephone', 'mobile_phone', 'work_phone', 'card_place_id'], 'string', 'max' => 50],
            [['card_number'], 'string', 'max' => 30],
            [['street_address_1', 'street_address_2', 'passport_place', 'tax_department', 'profile_image_path', 'password_reset_token', 'last_ip_address'], 'string', 'max' => 255],
            [['card_number_id', 'bank_number', 'passport_number', 'zip_code', 'tax_code'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
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
            'city_code' => Yii::t('app', 'City Code'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'username' => Yii::t('app', 'Username'),
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
            'is_visible' => Yii::t('app', 'Is Visible'),
            'profile_image_path' => Yii::t('app', 'Profile Image Path'),
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
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
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
    public static function isPasswordResetTokenValid($token)
    {
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
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
