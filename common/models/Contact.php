<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property string $id
 * @property string $name
 * @property string $subject
 * @property string $body
 * @property string $phone
 * @property string $email
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property boolean $disabled
 */
class Contact extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'body'], 'required'],
            [['body'], 'string'],
            [['datetime_created', 'lastup_datetime'], 'integer'],
            [['disabled'], 'boolean'],
            [['name', 'email'], 'string', 'max' => 100],
			[['email'], 'email'],
            [['subject'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'subject' => Yii::t('common', 'Subject'),
            'body' => Yii::t('common', 'Body'),
            'phone' => Yii::t('common', 'Phone'),
            'email' => Yii::t('common', 'Email'),
            'datetime_created' => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' => Yii::t('common', 'Lastup Datetime'),
            'disabled' => Yii::t('common', 'Disabled'),
        ];
    }
}
