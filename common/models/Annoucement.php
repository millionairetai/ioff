<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "annoucement".
 *
 * @property string $id
 * @property string $company_id
 * @property string $employee_id
 * @property string $title
 * @property string $description
 * @property string $description_parse
 * @property boolean $is_importance
 * @property string $date_new_to
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Annoucement extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'annoucement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'employee_id', 'date_new_to', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['title', 'description', 'description_parse'], 'required'],
            [['description', 'description_parse'], 'string'],
            [['is_importance', 'disabled'], 'boolean'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('member', 'ID'),
            'company_id' => Yii::t('member', 'Company ID'),
            'employee_id' => Yii::t('member', 'Employee ID'),
            'title' => Yii::t('member', 'Title'),
            'description' => Yii::t('member', 'Description'),
            'description_parse' => Yii::t('member', 'Description Parse'),
            'is_importance' => Yii::t('member', 'Is Importance'),
            'date_new_to' => Yii::t('member', 'Date New To'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
    
    public static function getAnnoucements($currentPage, $perPage = 4)  {
        $annoucements = self::find()->select(['annoucement.title', 'annoucement.id', 'annoucement.employee_id']);
        
        $totalItem = $annoucements->count();
        $annoucements = $annoucements 
                ->with('employee')
//                ->joinWith('activity')
                ->orderBy('annoucement.is_importance DESC, annoucement.datetime_created DESC')
                ->limit($perPage)
                ->offset(($currentPage - 1)* $perPage)
//                ->asArray()
                ->all();
//        print_r($annoucements->createCommand()->rawSql);die;
        return [
            'totalPage' => ceil($totalItem / $perPage),
            'annoucements' => $annoucements
        ];
                
    }
    
    public function getEmployee() {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }
    
//    public function getActivity() {
//        return $this->hasOne(Activity::className(), ['id' => 'owner_id', 'owner_table' => 'annoucement'])->select('activity.id');
//    }
}
