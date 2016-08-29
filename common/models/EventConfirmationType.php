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
     * Get count of status evetn attent
     * @param string $eventID
     * @param number $countDefault
     */
    public static function getInfoAttend($eventID = null) {
        $attent = EventConfirmation::find()->select([
                    EventConfirmation::tableName().'.employee_id',
                    EventConfirmation::tableName().'.event_confirmation_type_id',
                    EventConfirmationType::tableName().'.name',
                    EventConfirmationType::tableName().'.column_name'
                ])
                ->innerJoin('event_confirmation_type', ' event_confirmation_type.id = event_confirmation.event_confirmation_type_id')
                ->where(['event_confirmation.event_id' => $eventID, 'event_confirmation.company_id' => \Yii::$app->user->getCompanyId()])
                ->asArray()
                ->all();
        
        $result = [];
        $attendActive = '';
        $count = 0;
        foreach ($attent AS $key => $val) {
            $result[$val['column_name']][] = $val['employee_id'];
            $count ++;
            if ($val['employee_id'] == \Yii::$app->user->getId()) {
                $attendActive = $val['column_name'];
            }
        }
        
        $no_attend = $maybe = $attend = 0;
        if (!empty($result)) {
            if (isset($result[EventConfirmationType::ATTEND])) {
                $attend = count($result[EventConfirmationType::ATTEND]);
            }
            if (isset($result[EventConfirmationType::MAYBE])) {
                $maybe = count($result[EventConfirmationType::MAYBE]);
            }
            if (isset($result[EventConfirmationType::NO_ATTEND])) {
                $no_attend = count($result[EventConfirmationType::NO_ATTEND]);
            }
        }
        return  [
                    'activeAttendByEmployee'         => $attendActive,
                    'attendListEmployeeId'           => $result,
                    EventConfirmationType::ATTEND    => $attend,
                    EventConfirmationType::MAYBE     => $maybe,
                    EventConfirmationType::NO_ATTEND => $no_attend,
                    'countConfirm'                   => $count
                ];
    }

//     /**
//      * Get count of status evetn attent
//      * @param string $eventID
//      * @param number $countDefault
//      */
//     public static function getInfoAttent($eventID = null, $countDefault = 0) {
//         $attent = EventConfirmation::find()->select([
//                 EventConfirmation::tableName().'.event_confirmation_type_id',
//                 EventConfirmationType::tableName().'.name',
//                 EventConfirmationType::tableName().'.column_name AS column_name',
//                 'COUNT('.EventConfirmation::tableName().'.id) AS ordersCount'])
//                 ->innerJoin('event_confirmation_type', ' event_confirmation_type.id = event_confirmation.event_confirmation_type_id')
//                 ->where(['event_confirmation.event_id' => $eventID, 'event_confirmation.company_id' => \Yii::$app->user->getCompanyId()])
//                 ->groupBy('event_confirmation.event_confirmation_type_id') // group the result to ensure aggregation function works
//                 ->asArray()
//                 ->all();
         
//         $no_attend = $maybe = $attend = 0;
//         foreach ($attent AS $val) {
//             if (isset($val['column_name'])) {
//                 switch ($val['column_name']) {
//                     case EventConfirmationType::ATTEND:
//                         $attend = $val['ordersCount'];
//                         break;
//                     case EventConfirmationType::MAYBE:
//                         $maybe = $val['ordersCount'];
//                         break;
//                     case EventConfirmationType::NO_ATTEND:
//                         $no_attend = $val['ordersCount'];
//                         break;
//                 }
//                 $countDefault = $countDefault - $val['ordersCount'];
//             }
//         }
        
//         return  [
//                     EventConfirmationType::ATTEND    => $attend,
//                     EventConfirmationType::MAYBE     => $maybe,
//                     EventConfirmationType::NO_ATTEND => $no_attend,
//                     EventConfirmationType::NO_CONFIRM => $countDefault
//                 ];
//     }
    
//     /**
//      * Get count of status evetn attent
//      * @param string $eventID
//      * @param number $countDefault
//      */
//     public static function getActiveAttent($eventID = null, $employee_id = null) {
//        return EventConfirmation::find()->select([EventConfirmationType::tableName().'.column_name AS column_name'])
//                 ->innerJoin('event_confirmation_type', ' event_confirmation_type.id = event_confirmation.event_confirmation_type_id')
//                 ->where([
//                         'event_confirmation.event_id' => $eventID, 
//                         'event_confirmation.company_id' => \Yii::$app->user->getCompanyId(), 
//                         'event_confirmation.employee_id' => $employee_id]
//                         )
//                 ->asArray()
//                 ->all();
//     }
}
