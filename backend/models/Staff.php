<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use backend\components\db\ActiveRecord;

/**
 * This is the model class for table "{{%staff}}".
 *
 * @property string $id
 * @property integer $authority_id
 * @property string $job_id
 * @property string $name
 * @property string $email
 * @property string $phone_no
 * @property string $address
 * @property string $username
 * @property string $password
 * @property string $leaving_date
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Staff extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = false;
    const STATUS_ACTIVE = true;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%staff}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['authority_id', 'job_id', 'leaving_date', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['name', 'email', 'username', 'password'], 'required'],
            [['disabled'], 'boolean'],
            [['name', 'address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 99],
            [['phone_no'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'authority_id' => Yii::t('app', 'Authority ID'),
            'job_id' => Yii::t('app', 'Job ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone_no' => Yii::t('app', 'Phone No'),
            'address' => Yii::t('app', 'Address'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'leaving_date' => Yii::t('app', 'Leaving Date'),
            'datetime_created' => Yii::t('app', 'Datetime Created'),
            'lastup_datetime' => Yii::t('app', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('app', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('app', 'Lastup Employee ID'),
            'disabled' => Yii::t('app', 'Disabled'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
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
        return static::findOne(['username' => $username]);
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
    /**
     * get name profile
     * @return type
     */
    public function getFullname() {
        return Yii::$app->user->identity->name;
    }
}
