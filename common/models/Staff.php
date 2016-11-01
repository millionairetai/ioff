<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
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
class Staff extends \backend\components\db\ActiveRecord
{
    public $re_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
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
            [['password'], 'string', 'max' => 64],
            [['re_password'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
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
}
