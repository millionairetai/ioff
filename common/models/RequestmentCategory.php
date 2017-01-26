<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "requestment_category".
 *
 * @property string $id
 * @property string $company_id
 * @property string $name
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class RequestmentCategory extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requestment_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
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
            'name' => Yii::t('member', 'Name'),
            'description' => Yii::t('member', 'Description'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
    
    public static function getsIndexById() {
        return self::find()->select(['id', 'name'])
                ->indexBy('id')
                ->andCompanyId()
                ->asArray()
                ->all();
    }
}
