<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscriber".
 *
 * @property string $id
 * @property string $email
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property boolean $disabled
 */
class Subscriber extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['datetime_created', 'lastup_datetime'], 'integer'],
            [['disabled'], 'boolean'],
            [['email'], 'string', 'max' => 99]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'email' => Yii::t('common', 'Email'),
            'datetime_created' => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' => Yii::t('common', 'Lastup Datetime'),
            'disabled' => Yii::t('common', 'Disabled'),
        ];
    }
}
