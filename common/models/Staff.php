<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\IdentityInterface;
use common\models\Job;

/**
 * This is the model class for table "staff".
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
class Staff extends \backend\components\db\ActiveRecord  implements IdentityInterface {

    public $re_password;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['authority_id', 'job_id', 'leaving_date', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['name', 'email', 'username', 'password'], 'required'],
            [['disabled'], 'boolean'],
            [['name', 'address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 99],
            [['phone_no'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 64],
            [['re_password'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'authority_id' => Yii::t('common', 'Authority'),
            'job_id' => Yii::t('backend', 'Job'),
            'name' => Yii::t('common', 'Name'),
            'email' => Yii::t('common', 'Email'),
            'phone_no' => Yii::t('common', 'Phone'),
            'address' => Yii::t('common', 'Address'),
            'username' => Yii::t('common', 'Username'),
            'password' => Yii::t('common', 'Password'),
            're_password' => Yii::t('common', 'Re-Password'),
            'leaving_date' => Yii::t('backend', 'Leaving Date'),
            'datetime_created' => Yii::t('backend', 'Datetime Created'),
            'lastup_datetime' => Yii::t('backend', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('backend', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('backend', 'Lastup Employee ID'),
            'disabled' => Yii::t('backend', 'Disabled'),
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = static::find()
//                ->select(['staff.*', 'job.name as job_name'])
                ->joinWith(['job']);
//                ->joinWith(['authority']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => self::PAGE_SIZE)
        ]);
        if (!($this->load($params))) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'staff.name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'address', $this->address]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->orFilterWhere(['like', 'job.name', $this->name]);

        return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob() {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthority() {
        return $this->hasOne(Authority::className(), ['id' => 'authority_id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
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
     * get name profile
     * @return type
     */
    public function getFullname() {
        return Yii::$app->user->identity->name;
    }

}
