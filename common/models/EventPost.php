<?php

namespace common\models;
use common\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "event_post".
 *
 * @property string $id
 * @property string $company_id
 * @property string $event_id
 * @property string $employee_id
 * @property string $parent_employee_id
 * @property string $parent_id
 * @property string $content
 * @property string $content_parse
 * @property boolean $is_log_history
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class EventPost extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'event_id', 'employee_id', 'parent_employee_id', 'parent_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['content', 'content_parse'], 'required'],
            [['content', 'content_parse'], 'string'],
            [['is_log_history', 'disabled'], 'boolean']
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
            'parent_employee_id' => 'Parent Employee ID',
            'parent_id' => 'Parent ID',
            'content' => 'Content',
            'content_parse' => 'Content Parse',
            'is_log_history' => 'Is Log History',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee() {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }
    
    /**
     * Get list event post by event id
     *
     * @param integer $eventId
     * @param integer $currentPage
     * @param integer $itemPerPage
     * @return array|boolean
     */
    public static function getEventPosts($eventId, $offset = 0, $itemPerPage = 10) {
//        $offset = --$currentPage * $itemPerPage;
        if (isset($eventId)){
            $data =  EventPost::find()
                            ->select(['id', 'employee_id', 'datetime_created', 'content', 'created_employee_id', 'is_log_history'])
                            ->where(['event_id' => $eventId])
                            ->andCompanyId()
                            ->orderBy('datetime_created DESC')
                            ->limit($itemPerPage)
                            ->offset($offset)
                            ->all();
            return $data;
        }
        
        return [];
    }
}
