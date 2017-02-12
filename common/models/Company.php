<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\PlanType;
use common\models\Language;
use common\models\Employee;

/**
 * This is the model class for table "company".
 *
 * @property string $id
 * @property integer $status_id
 * @property string $plan_type_id
 * @property integer $language_id
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $phone_no
 * @property string $domain
 * @property string $profile_image_path
 * @property string $description_title
 * @property string $description
 * @property string $start_date
 * @property string $expired_date
 * @property string $language_code
 * @property string $total_storage
 * @property integer $total_employee
 * @property integer $max_user_register
 * @property integer $max_storage_register
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Company extends \backend\components\db\ActiveRecord {

    //Status of company.
    const COLUNM_NAME_ACTIVE = 'company.active';
    const COLUNM_NAME_INACTIVE = 'company.inactive';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['status_id', 'plan_type_id', 'language_id', 'start_date', 'expired_date', 'total_storage', 'total_employee', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id', 'max_user_register', 'max_storage_register'], 'integer'],
            [['name', 'email', 'phone_no', 'language_code'], 'required'],
            [['description_title', 'description'], 'string'],
            [['disabled'], 'boolean'],
            [['name', 'address', 'profile_image_path'], 'string', 'max' => 255],
            [['email', 'domain'], 'string', 'max' => 99],
            [['phone_no'], 'string', 'max' => 50],
            [['language_code'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'status_id' => Yii::t('common', 'Status'),
            'plan_type_id' => Yii::t('common', 'Plan type'),
            'language_id' => Yii::t('common', 'Language'),
            'name' => Yii::t('common', 'Name'),
            'email' => Yii::t('common', 'Email'),
            'address' => Yii::t('common', 'Address'),
            'phone_no' => Yii::t('common', 'Phone'),
            'domain' => Yii::t('common', 'Domain'),
            'profile_image_path' => Yii::t('common', 'Profile Image Path'),
            'description_title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'start_date' => Yii::t('common', 'Start Date'),
            'expired_date' => Yii::t('common', 'Expired Date'),
            'language_code' => Yii::t('common', 'Language Code'),
            'total_storage' => Yii::t('common', 'Total Storage'),
            'total_employee' => Yii::t('common', 'Total Employee'),
            'max_user_register' => Yii::t('common', 'Max Storage Register'),
            'max_storage_register' => Yii::t('common', 'Max Storage Register'),
            'datetime_created' => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' => Yii::t('common', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('common', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' => Yii::t('common', 'Disabled'),
        ];
    }

    public function getEmployees() {
        return $this->hasMany(Employee::className(), ['company_id' => 'id']);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = static::find()
//                ->select(['staff.*', 'job.name as job_name'])
                ->joinWith(['status'])
                ->joinWith(['plan_type'])
                ->orderBy('datetime_created DESC');

//                ->joinWith(['authority']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10)
        ]);
        if (!($this->load($params))) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'company.name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'address', $this->address]);
        $query->andFilterWhere(['like', 'phone_no', $this->phone_no]);
        $query->orFilterWhere(['like', 'domain', $this->domain]);

        return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus() {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan_type() {
        return $this->hasOne(PlanType::className(), ['id' => 'plan_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage() {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * Get company detail by company id
     * 
     * @param interger $companyId
     * @return array
     */
    public static function getDetailByCompanyId($companyId) {
        return self::find()
                        ->select(['translation.translated_text AS plan_type_name', 'company.name AS company_name', 'status.column_name AS status_column_name',
                            'company.total_storage', 'company.total_employee', 'company.start_date', 'company.expired_date', 'company.id', 'company.created_employee_id',
                            'company.phone_no', 'company.plan_type_id', 'company.max_user_register', 'company.max_storage_register', 'plan_type.name AS plan_type_name'])
                        ->leftJoin('plan_type', 'plan_type.id = company.plan_type_id')
//                        ->leftJoin('plan_type_detail', 'plan_type_detail.plan_type_id = plan_type.id')
                        ->leftJoin('status', 'company.status_id = status.id')
                        ->leftJoin('translation', 'translation.owner_id=plan_type.id AND translation.owner_table="plan_type"')
                        ->leftJoin('language', 'language.id = translation.language_id')
                        ->where(['company.id' => $companyId, 'language.language_code' => Yii::$app->language])
                        ->asArray()
                        ->one();
    }

}
