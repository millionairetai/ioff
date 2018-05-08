<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invitee".
 *
 * @property string $id
 * @property string $company_id
 * @property string $event_id
 * @property string $employee_id
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Invitee extends \common\components\db\ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invitee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'event_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['event_id', 'employee_id'], 'required'],
            [['disabled'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'event_id' => 'Event ID',
            'employee_id' => 'Employee ID',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }    
    
    /**
     * Add invitee batchInsert
     * 
     * @param array $dataInsert
     * @return boolean
     */
//    public static function batchInsert($dataInsert) {
//        if (!empty($dataInsert)) {
//            if (!\Yii::$app->db->createCommand()->batchInsert(self::tableName(), array_keys($dataInsert[0]), $dataInsert)->execute()) {
//                throw new \Exception('Save record to table invitee fail');
//            }
//        }
//        
//        return true;
//    }
}
