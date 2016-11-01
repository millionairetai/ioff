<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

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
            [['password'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'authority_id' => Yii::t('backend', 'Authority ID'),
            'job_id' => Yii::t('backend', 'Job ID'),
            'name' => Yii::t('backend', 'Name'),
            'email' => Yii::t('backend', 'Email'),
            'phone_no' => Yii::t('backend', 'Phone No'),
            'address' => Yii::t('backend', 'Address'),
            'username' => Yii::t('backend', 'Username'),
            'password' => Yii::t('backend', 'Password'),
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
        $query = static::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => self::PAGE_SIZE)
        ]);
        if (!($this->load($params))) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'address', $this->address]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        
        return $dataProvider;
    }
}
