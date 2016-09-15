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
    const NO_ATTEND = "no_attend";
    const MAYBE     = "maybe";
    const ATTEND    = 'attend';
    const NO_CONFIRM= 'no_confirm';
    
    //Value no confirm
    const VAL_NO_CONFIRM = 0;

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
    
    /**
     * Get count of status evetn attend
     * 
     * @param string $eventId
     * @param number $countDefault
     */
    public static function getInfoAttend($eventId = null) {
        $attent = EventConfirmation::find()->select([
                    EventConfirmation::tableName().'.employee_id',
                    EventConfirmation::tableName().'.event_confirmation_type_id',
                    EventConfirmationType::tableName().'.name',
                    EventConfirmationType::tableName().'.column_name'
                ])
                ->innerJoin('event_confirmation_type', ' event_confirmation_type.id = event_confirmation.event_confirmation_type_id')
                ->where(['event_confirmation.event_id' => $eventId, 'event_confirmation.company_id' => \Yii::$app->user->getCompanyId()])
                ->asArray()
                ->all();
        
        $result = [];
        $attendActive = '';
        foreach ($attent as $key => $val) {
            $result[$val['column_name']][] = $val['employee_id'];
            if ($val['employee_id'] == \Yii::$app->user->getId()) {
                $attendActive = $val['column_name'];
            }
        }
        
        $noAttend = $maybe = $attend = 0;
        if (!empty($result)) {
            if (isset($result[EventConfirmationType::ATTEND])) {
                $attend = count($result[EventConfirmationType::ATTEND]);
            }
            if (isset($result[EventConfirmationType::MAYBE])) {
                $maybe = count($result[EventConfirmationType::MAYBE]);
            }
            if (isset($result[EventConfirmationType::NO_ATTEND])) {
                $noAttend = count($result[EventConfirmationType::NO_ATTEND]);
            }
        }
        return  [
                    'activeAttendByEmployee'         => $attendActive,
                    'attendListEmployeeId'           => $result,
                    EventConfirmationType::ATTEND    => $attend,
                    EventConfirmationType::MAYBE     => $maybe,
                    EventConfirmationType::NO_ATTEND => $noAttend,
                ];
    }
        
    /**
     * Get number of confirmed employee
     * 
     * @param integer $eventId
     * @return integer
     */
    public static function getEventConfirmationTypes() {
    	return EventConfirmationType::find()->select(['id', 'name', 'column_name'])->all();;
    }
}
