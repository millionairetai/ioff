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
            [['calendar_id', 'employee_id', 'start_datetime', 'end_datetime', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['employee_id', 'name', 'description', 'description_parse'], 'required'],
            [['description', 'description_parse'], 'string'],
            [['is_public', 'disabled'], 'boolean'],
            [['name', 'address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calendar_id' => 'Calendar ID',
            'employee_id' => 'Employee ID',
            'name' => 'Name',
            'description' => 'Description',
            'description_parse' => 'Description Parse',
            'address' => 'Address',
            'start_datetime' => 'Start Datetime',
            'end_datetime' => 'End Datetime',
            'is_public' => 'Is Public',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
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
