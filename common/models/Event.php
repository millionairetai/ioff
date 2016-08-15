<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event".
 *
 * @property string $id
 * @property string $company_id
 * @property integer $calendar_id
 * @property string $employee_id
 * @property string $name
 * @property string $description
 * @property string $description_parse
 * @property string $address
 * @property string $start_datetime
 * @property integer $end_datetime
 * @property boolean $is_public
 * @property string $color
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Event extends ActiveRecord {

    public $sms = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_id', 'calendar_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer', 'message' => Yii::t('member', 'validate_integer')],
            [['employee_id', 'name', 'start_datetime', 'end_datetime'], 'required', 'message' => Yii::t('member', 'validate_required')],
            [['description', 'description_parse'], 'string', 'message' => Yii::t('member', 'validate_string')],
            [['is_public', 'disabled'], 'boolean', 'message' => Yii::t('member', 'validate_boolean')],
            [['start_datetime', 'end_datetime', 'address', 'description', 'description_parse', 'sms', 'color'], 'safe'],
            ['end_datetime', 'compare', 'compareAttribute' => 'start_datetime', 'operator' => '>','message' => Yii::t('member', 'validate_time')],
            [['name', 'address'], 'string', 'max' => 255, 'tooLong' => Yii::t('member', 'validate_max_length')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'event_id'),
            'company_id' => Yii::t('common', 'event_company_id'),
            'calendar_id' => Yii::t('common', 'event_calendar_id'),
            'employee_id' => Yii::t('common', 'event_employee_id'),
            'name' => Yii::t('common', 'event_name'),
            'description' => Yii::t('common', 'event_description'),
            'description_parse' => Yii::t('common', 'event_description_parse'),
            'address' => Yii::t('common', 'event_address'),
            'start_datetime' => Yii::t('common', 'event_start_datetime'),
            'end_datetime' => Yii::t('common', 'event_end_datetime'),
            'is_public' => Yii::t('common', 'event_is_public'),
            'datetime_created' => Yii::t('common', 'event_datetime_created'),
            'lastup_datetime' => Yii::t('common', 'event_lastup_datetime'),
            'lastup_employee_id' => Yii::t('common', 'event_lastup_employee_id'),
            'disabled' => Yii::t('common', 'event_disabled'),
        ];
    }

    public static function getDepartmentNameCheckBox() {
        return ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'name');
    }

    public static function getCalendarOption() {
        return ArrayHelper::map(Calendar::find()->asArray()->all(), 'id', 'name');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendar() {
        return $this->hasOne(Calendar::className(), ['id' => 'calendar_id']);
    }

    /**
     * Get all calendar in company
     * 
     * @param array $calendars
     * @param integer $companyId
     * @param integer $employeeId
     * @param string $start
     * @param string $end
     * @return array
     */
    public static function getEvents($calendars, $companyId, $employeeId, $start, $end) {

        $sql = " SELECT event.name,event.start_datetime,event.end_datetime,event.color "
                . " FROM event "
                . "        INNER JOIN calendar	"
                . "                ON event.calendar_id= calendar.id "
                . "                        AND calendar.company_id={$companyId} "
                . "                        AND calendar.disabled=" . self::STATUS_ENABLE
                . " WHERE ( "
                . "       event.is_public=1 "
                . "       OR event.created_employee_id={$employeeId}	 "
                . "       OR (EXISTS( "
                . "                      SELECT * "
                . "                       FROM invitation "
                . "                       WHERE invitation.event_id= event.id "
                . "                               AND invitation.owner_id={$employeeId} "
                . "                               AND invitation.owner_table='employee' "
                . "                               AND invitation.company_id={$companyId} "
                . "                               AND invitation.disabled=" . self::STATUS_ENABLE
                . "                       ) "
                . "               ) "
                . "       OR(EXISTS( "
                . "                       SELECT * "
                . "                       FROM invitation "
                . "                               INNER JOIN department "
                . "                                       ON invitation.owner_id=department.id "
                . "                                               AND invitation.owner_table='department' "
                . "                                               AND department.company_id={$companyId} "
                . "                                               AND department.disabled=" . self::STATUS_ENABLE
                . "                               INNER JOIN employee "
                . "                                       ON department.id=employee.department_id "
                . "                                               AND employee.company_id={$companyId} "
                . "                                               AND employee.id={$employeeId} "
                . "                                               AND employee.disabled=" . self::STATUS_ENABLE
                . "                       WHERE invitation.event_id=event.id "
                . "                               AND invitation.company_id={$companyId} "
                . "                               AND invitation.disabled=" . self::STATUS_ENABLE
                . "                       ) "
                . "               ) "
                . "       ) "
                . " AND event.end_datetime <=  " . strtotime($end . " 23:59:59")
                . " AND event.start_datetime >= " . strtotime($start . " 00:00:00")
                . " AND event.company_id={$companyId} "
                . " AND event.disabled=" . self::STATUS_ENABLE;

        if (!empty($calendars)) {
            $sql .= " AND event.calendar_id  IN (" . implode(',', $calendars) . ") ";
            $command = \Yii::$app->getDb()->createCommand($sql);
            return $command->queryAll();
        }
        
        return [];
    }
    
    /**
     * Get all calendar in company
     * 
     * @param array $calendars
     * @param integer $companyId
     * @param integer $employeeId
     * @param string $start
     * @param string $end
     * @return array
     */
    public static function getInfoEvent($eventId = null) {
        if (empty($eventId)) {
            return false;
        }

        $eventId = 1;
        //get Id company of user login
        $companyId = \Yii::$app->user->getCompanyId();
        $event = Event::findOne(['id' => $eventId, 'company_id' => $companyId]);
        if (empty($event)) {
            return false;
        }
        
        //Get file with where: project_id, company_id, owner_table=project
        $fileList = File::getFileByOwnerIdAndTable($eventId, Event::tableName());
        
        
        
        
        $result = [
                'event' => [
                        'name'              => $event->name,
                        'color'             => $event->color,
                        'address'           => $event->address,
                        'description'       => $event->description,
                        'description_parse' => $event->description_parse,
                        'start_datetime'    => $event->start_datetime,
                        'end_datetime'      => $event->end_datetime,
                ],
                'calendar' => [
                        'name' => $event->calendar->getName(),
                ],
                'file_info' => $fileList,
                //                 'event_confirmation' => [
                        //                         'name' => ,
                        //                 ],
        ];
        print_r($result);
        
        
        die;
        
        
        //get Id company of user login
        
        
        return [];
    }

}
