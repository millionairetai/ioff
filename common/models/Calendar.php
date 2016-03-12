<?php

namespace common\models\work;

use common\components\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Calendar extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
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
            'id' 				 => Yii::t('common', 'ID'),
            'name' 				 => Yii::t('common', 'Event Calendar'),
            'description' 		 => Yii::t('common', 'Description'),
            'datetime_created' 	 => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('common', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' 			 => Yii::t('common', 'Disabled'),
        ];
    }
}
