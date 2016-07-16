<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sms_template".
 *
 * @property integer $id
 * @property integer $sending_template_group_id
 * @property integer $language_id
 * @property string $body
 * @property string $column_name
 * @property string $default_from_phone_no
 * @property string $language_code
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class SmsTemplate extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sending_template_group_id', 'body', 'column_name'], 'required'],
            [['sending_template_group_id', 'language_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['body'], 'string'],
            [['disabled'], 'boolean'],
            [['column_name'], 'string', 'max' => 99],
            [['default_from_phone_no', 'language_code'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sending_template_group_id' => 'Sending Template Group ID',
            'language_id' => 'Language ID',
            'body' => 'Body',
            'column_name' => 'Column Name',
            'default_from_phone_no' => 'Default From Phone No',
            'language_code' => 'Language Code',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    
    /**
     * get theme sms of creating project 
     */
    public static function getThemeCreateProject(){
        $theme = self::find()->andWhere(['column_name' => 'create_project','language_code' => \Yii::$app->language])->one();
        if($theme) {
            return $theme;
        }
        return null;
    }
    
    /**
     * Get theme sms of creating event 
     * 
     * @return string|null
     */
    public static function getThemeCreateEvent() {
        $theme = self::find()->andWhere(['column_name' => 'create_event','language_code' => \Yii::$app->language])->one();
        if($theme) {
            return $theme;
        }
        
        return null;
    }
    
    /**
     * Get theme sms of edit project 
     */
    public static function getThemeEditProject(){
        $theme = self::find(['column_name' => 'edit_project','language_code' => \Yii::$app->language])->one();
        if($theme){
            return $theme;
        }
        return null;
    }    
}
