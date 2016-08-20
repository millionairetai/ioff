<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_confirmation".
 *
 * @property string $id
 * @property string $name
 * @property string $column_name
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class EventConfirmationType extends \common\components\db\ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_confirmation_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'column_name', 'description', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean']
        ];
    }
}
