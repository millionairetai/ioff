<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_confirmation".
 *
 * @property string $id
 * @property string $company_id
 * @property string $employee_id
 * @property string $event_id
 * @property string $event_confirmation_type_id
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class EventConfirmation extends \common\components\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'event_confirmation';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_id', 'employee_id', 'event_id', 'event_confirmation_type_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('member', 'ID'),
            'company_id' => Yii::t('member', 'Company ID'),
            'employee_id' => Yii::t('member', 'Employee ID'),
            'event_id' => Yii::t('member', 'Event ID'),
            'event_confirmation_type_id' => Yii::t('member', 'Event Confirmation Type ID'),
            'datetime_created' => Yii::t('member', 'Datetime Created'),
            'lastup_datetime' => Yii::t('member', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('member', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('member', 'Lastup Employee ID'),
            'disabled' => Yii::t('member', 'Disabled'),
        ];
    }

    /**
     * Get number of confirmed employee
     * 
     * @param integer $eventId
     * @return integer
     */
    public static function getNumberConfirmedEmployee($eventId) {
        return EventConfirmation::find()->where(['event_confirmation_type_id' => EventConfirmationType::VAL_NO_CONFIRM, 'event_id' => $eventId])->count();
    }

    /**
     * Check if user is invitee.
     * 
     * @param integer $eventId
     * @return integer
     */
    public static function isInivtee($eventId) {
        $invitee = self::find()->select(['id'])->where([
                    'event_id' => $eventId,
                    'employee_id' => Yii::$app->user->identity->id,
                ])->one();

        if ($invitee) {
            return true;
        }
        
        return false;
    }

}
