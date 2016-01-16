<?php

namespace common\models\work;

use common\components\db\CeActivieRecord;

use Yii;

/**
 * This is the model class for table "remind".
 *
 * @property string $id
 * @property string $employee_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $content
 * @property string $remind_datetime
 * @property string $minute_before
 * @property string $repeated_time
 * @property boolean $is_snoozing
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $is_remind
 */
class Remind extends CeActivieRecord
{
	public $is_remind;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'remind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'owner_id', 'remind_datetime', 'minute_before', 'repeated_time', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['owner_table', 'repeated_time', 'minute_before'], 'required'],
            [['content'], 'string'],
            [['is_snoozing', 'is_remind'], 'boolean'],
            [['owner_table'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('common', 'ID'),
            'employee_id' 		 => Yii::t('common', 'Employee ID'),
            'owner_id' 			 => Yii::t('common', 'Owner ID'),
            'owner_table' 		 => Yii::t('common', 'Owner Table'),
            'content' 			 => Yii::t('common', 'Content'),
            'remind_datetime' 	 => Yii::t('common', 'Remind Datetime'),
            'minute_before' 	 => Yii::t('common', 'Minute Before'),
            'repeated_time' 	 => Yii::t('common', 'Repeated Time'),
            'is_snoozing' 		 => Yii::t('common', 'Is Snoozing'),
            'datetime_created'   => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('common', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'is_remind' 	 	 => Yii::t('common', 'is_remind'),
        ];
    }
    
    /**
     * @description show option time 10 20 30 40 50 60
     * @author minhtha
     * @return array time
     */
    public static function getTimeRemind(){
    	return [
    	'10' => '10',
    	'20' => '20',
    	'30' => '30',
    	'40' => '40',
    	'50' => '50',
    	'60' => '60',
    	];
    }
}
