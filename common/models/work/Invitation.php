<?php

namespace common\models\work;

use common\components\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "invitation".
 *
 * @property string $id
 * @property string $event_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Invitation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invitation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'owner_id'], 'required'],
            [['event_id', 'owner_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['owner_table'], 'string', 'max' => 99]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('common', 'ID'),
            'event_id' 			 => Yii::t('common', 'Event ID'),
            'owner_id' 			 => Yii::t('common', 'Owner ID'),
            'owner_table' 		 => Yii::t('common', 'Owner Table'),
            'datetime_created'   => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('common', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' 			 => Yii::t('common', 'Disabled'),
        ];
    }
}
