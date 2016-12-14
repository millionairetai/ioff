<?php

namespace common\models;

use common\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Calendar extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['company_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'company_id' => Yii::t('common', 'Company id'),
            'name' => Yii::t('common', 'Event Calendar'),
            'description' => Yii::t('common', 'Description'),
            'datetime_created' => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' => Yii::t('common', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' => Yii::t('common', 'Disabled'),
        ];
    }

    /**
     * Get all calendar in company
     * 
     * @param integer $companyId
     * @param integer $employeeId
     * @return array
     */
    public static function getAllCalendar($companyId, $employeeId) {
        $sql = "SELECT event.calendar_id, calendar.name, calendar.description, count(event.id) AS `number_event`																
                FROM event																
                    INNER JOIN calendar ON event.calendar_id= calendar.id AND calendar.company_id={$companyId} AND calendar.disabled=0															
                    WHERE (event.is_public=1 OR event.created_employee_id={$employeeId} OR (EXISTS(															
                    SELECT *															
                    FROM invitation															
                    WHERE invitation.event_id= event.id AND invitation.owner_id={$employeeId} AND invitation.owner_table='employee' AND invitation.company_id={$companyId} AND invitation.disabled=0)) OR(EXISTS(															
                    SELECT *															
                    FROM invitation															
                    INNER JOIN department ON invitation.owner_id=department.id AND invitation.owner_table='department' AND department.company_id={$companyId} AND department.disabled=0															
                    INNER JOIN employee ON department.id=employee.department_id AND employee.company_id={$companyId} AND employee.id={$employeeId} AND employee.disabled=0															
                        WHERE invitation.event_id=event.id 																
                    AND invitation.company_id={$companyId} 															
                    AND invitation.disabled=0)))															
                    AND event.start_datetime >= " . strtotime(date('Y-m-d') . " 00:00:00") . "
                    AND event.company_id={$companyId} 															
                    AND event.disabled=0																								
                GROUP BY event.calendar_id 
                ORDER BY number_event DESC";

        $command = \Yii::$app->db->createCommand($sql);
        $data = $command->queryAll();
        $ids = self::getAllId($data);

        if ($calendars = self::find()->select(['id', 'name', 'description'])->andCompanyId()->orderBy('datetime_created ASC')->asArray()->all()) {
            foreach ($calendars as $calendar) {
                if (!in_array($calendar['id'], $ids)) {
                    $data[] = [
                        'calendar_id' => $calendar['id'],
                        'name' => $calendar['name'],
                        'description' => $calendar['description'],
                        'number_event' => 0,
                    ];

                    $ids[] = $calendar['id'];
                }
            }
        }

        return $data;
    }

    /**
     * Get all calendar id from array
     * 
     * @param resource $data
     * @return array
     */
    public static function getAllId($data) {
        $return = [];
        foreach ($data as $item) {
            $return[] = $item['calendar_id'];
        }

        return $return;
    }
    
    /**
     * Get calendar by name
     *
     * @param string $name
     * @return object
     */
    public static function getByName($name) {
        return self::find()->andWhere(['name' => $name])->andCompanyId()->one();
    }
    
    /**
     * Get celendar by id
     * 
     * @param integer $id
     * @return string
     */
//    public static function getById($id) {
//        return self::find()->select("name")->where(['id' => $id])->one();
//    }
       
    /**
     * Get celendar Name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
 
}
