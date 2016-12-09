<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "translation".
 *
 * @property integer $id
 * @property integer $languague_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $translated_text
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property integer $disabled
 */
class Translation extends \backend\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languague_id', 'owner_table', 'translated_text'], 'required'],
            [['languague_id', 'owner_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id', 'disabled'], 'integer'],
            [['owner_table'], 'string', 'max' => 50],
            [['translated_text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'languague_id' => Yii::t('common', 'Languague ID'),
            'owner_id' => Yii::t('common', 'Owner ID'),
            'owner_table' => Yii::t('common', 'Owner Table'),
            'translated_text' => 'xx',
            'datetime_created' => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' => Yii::t('common', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('common', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' => Yii::t('common', 'Disabled'),
        ];
    }
    
    /**
     * Get all task follow employess login
     */
    public static function getByParams($params) {
        return self::find()
                        ->select(['owner_id', 'owner_table', 'translated_text'])
                        ->where($params)
//                        ->asArray()
                        ->one();
    }
}
