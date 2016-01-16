<?php
/**
 * @author minh-tha
 * @create date 2016-01-06
 */

namespace common\models\work;

use Yii;
use common\components\db\CeActivieRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event".
 *
 * @property string $id
 * @property integer $calendar_id
 * @property string $employee_id
 * @property string $name
 * @property string $description
 * @property string $description_parse
 * @property string $address
 * @property string $start_datetime
 * @property integer $end_datetime
 * @property boolean $is_public
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Event extends CeActivieRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['employee_id', 'name', 'description', 'description_parse', 'start_datetime', 'end_datetime', 'address' ], 'required'],
            [['description', 'description_parse'], 'string'],
            [['is_public', 'disabled'], 'boolean'],
            [['start_datetime', 'end_datetime'], 'safe'],
            ['start_datetime','compare','compareAttribute'=>'end_datetime','operator'=>'>'],
            [['name', 'address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('common', 'ID'),
            'calendar_id' 		 => Yii::t('common', 'Calendar ID'),
            'employee_id' 		 => Yii::t('common', 'Employee ID'),
            'name' 				 => Yii::t('common','Name'),
            'description' 		 => Yii::t('common', 'Description'),
            'description_parse'  => Yii::t('common', 'Description Parse'),
            'address' 			 => Yii::t('common', 'Address'),
            'start_datetime' 	 => Yii::t('common', 'Start Datetime'),
            'end_datetime' 		 => Yii::t('common', 'End Datetime'),
            'is_public' 		 => Yii::t('common', 'Is Public'),
            'datetime_created' 	 => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('common', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' 			 => Yii::t('common', 'Disabled'),
        ];
    }
    
    public static function getDepartmentNameCheckBox()
    {
    	return ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'name');
    }
    
    public static function getCalendarOption()
    {
    	return ArrayHelper::map(Calendar::find()->asArray()->all(), 'id', 'name');
    }
}
