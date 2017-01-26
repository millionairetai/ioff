<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "requestment".
 *
 * @property string $id
 * @property string $company_id
 * @property string $requestment_category_id
 * @property string $review_employee_id
 * @property string $title
 * @property string $description
 * @property string $description_parse
 * @property string $from_datetime
 * @property integer $to_datetime
 * @property string $refused_reason
 * @property boolean $is_accept
 * @property boolean $is_public
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Requestment extends \common\components\db\ActiveRecord
{
    const STATUS_COLUMN_NAME_INPROGESS = 'requestment.inprogress';
    const STATUS_COLUMN_NAME_COMPLETED = 'requestment.completed';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requestment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'requestment_category_id', 'review_employee_id', 'from_datetime', 'to_datetime', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['title', 'description',], 'required'],
            [['description', 'description_parse', 'refused_reason'], 'string'],
            [['is_accept', 'is_public', 'disabled'], 'boolean'],
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
            'requestment_category_id' => Yii::t('member', 'Requestment Category ID'),
            'review_employee_id' => Yii::t('member', 'Review Employee ID'),
            'title' => Yii::t('member', 'Title'),
            'description' => Yii::t('member', 'Description'),
            'description_parse' => Yii::t('member', 'Description Parse'),
            'from_datetime' => Yii::t('member', 'From Datetime'),
            'to_datetime' => Yii::t('member', 'To Datetime'),
            'refused_reason' => Yii::t('member', 'Refused Reason'),
            'is_accept' => Yii::t('member', 'Is Accept'),
            'is_public' => Yii::t('member', 'Is Public'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
}
