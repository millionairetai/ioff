<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activity_post".
 *
 * @property string $id
 * @property string $company_id
 * @property string $employee_id
 * @property string $content
 * @property string $content_parse
 * @property integer $is_public
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class ActivityPost extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['content'], 'required'],
            [['content', 'content_parse'], 'string'],
            [['disabled', 'is_public'], 'boolean']
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
            'content' => Yii::t('member', 'content'),
            'content_parse' => Yii::t('member', 'Content Parse'),
            'is_public' => Yii::t('member', 'Is Public'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }
}
