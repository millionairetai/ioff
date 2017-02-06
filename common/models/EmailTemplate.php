<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_template".
 *
 * @property integer $id
 * @property integer $sending_template_group_id
 * @property integer $language_id 
 * @property string $subject
 * @property string $body
 * @property string $column_name
 * @property string $default_from_email
 * @property string $remark
 * @property string $language_code
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class EmailTemplate extends \common\components\db\ActiveRecord
{
    //const for column name.
    const CREATE_EVENT = 'create_event';
    const EDIT_EVENT = 'edit_event';
    const CREATE_PROJECT = 'create_project';
    const CREATE_PROJECT_POST = 'create_project_post';
    const CREATE_EVENT_POST = 'create_event_post';
    const CREATE_REQUESTMENT = 'create_requestment';
    const INVITE_NEW_EMPLOYEE = 'invite_new_employee';
    const SUCCESS_COMPANY_REGISTRATION = 'success_company_registration';
    const SUCCESS_COMPANY_REGISTRATION_FREE = 'success_company_registration_free';
    const SUCCESS_EMPLOYEE_REGISTRATION = 'success_employee_registration';
    const REQUEST_PASSWORD_AGAIN = 'request_password_again';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sending_template_group_id', 'subject', 'body', 'column_name'], 'required'],
            [['language_id', 'sending_template_group_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['body', 'remark'], 'string'],
            [['disabled'], 'boolean'],
            [['subject', 'default_from_email'], 'string', 'max' => 255],
            [['column_name'], 'string', 'max' => 99],
            [['language_code'], 'string', 'max' => 50]
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
            'language_id' => 'Language id',
            'subject' => 'Subject',
            'body' => 'Body',
            'column_name' => 'Column Name',
            'default_from_email' => 'Default From Email',
            'remark' => 'Remark',
            'language_code' => 'Language Code',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    /**
     * Get theme email of creating project 
     */
    public static function getThemeCreateProject(){
        
        $theme = self::find([
            'column_name' => 'create_project',
            'language_code' => \Yii::$app->language,
            'disabled' => self::STATUS_ENABLE
        ])->one();
        
        if($theme){
            return $theme;
        }
        
        return null;
    }
    
    public static function getThemeCreateTaskForAssigner(){
        $theme = self::find()->andWhere(['column_name' => 'create_project','language_code' => \Yii::$app->language])->one();
        if($theme){
            return $theme;
        }
        
        return null;
    }
    
    public static function getThemeCreateTaskForFollower(){
        $theme = self::find()->andWhere(['column_name' => 'create_project','language_code' => \Yii::$app->language])->one();
        if($theme){
            return $theme;
        }
        
        return null;
    }
    
    /**
     * Get theme email of creating event 
     * 
     * @return string|null
     */
    public static function getThemeCreateEvent(){
        
        $theme = self::find([
            'column_name' => 'create_event',
            'language_code' => \Yii::$app->language,
            'disabled' => self::STATUS_ENABLE
        ])->one();
        
        if($theme){
            return $theme;
        }
        
        return null;
    }
    
    /**
     * Get theme email of Edit project 
     */
    public static function getThemeEditProject() {
        
        $theme = self::find([
            'column_name' => 'edit_project',
            'language_code' => \Yii::$app->language,
            'disabled' => self::STATUS_ENABLE
        ])->one();
        
        if($theme){
            return $theme;
        }
        
        return null;
    }
    
    /**
     * Get theme email of project post
     */
    public static function getThemeProjectPost() {
        
        $theme = self::find()
                    ->select(['subject', 'body', 'default_from_email'])
                    ->where([
                        'column_name' => self::CREATE_PROJECT_POST,
                        'language_code' => \Yii::$app->language,
                        'disabled' => self::STATUS_ENABLE
                    ])->one();
        
        if($theme){
            return $theme;
        }
        
        return null;
    }

    /**
     * Get theme email of add  event post
     * 
     * @return string|null
     */
    public static function getThemeCreateEventPost(){
        
        $theme = self::find([
            'column_name' => Activity::TYPE_CREATE_EVENT_POST,
            'language_code' => \Yii::$app->language,
            'disabled' => self::STATUS_ENABLE
        ])->one();
        
        if($theme){
            return $theme;
        }
        
        return null;
    }

    /**
     * Get theme email of creating event 
     * 
     * @return string|null
     */
    public static function getThemeEditEvent(){
        
        $theme = self::find([
            'column_name' => Activity::TYPE_EDIT_EVENT,
            'language_code' => \Yii::$app->language,
            'disabled' => self::STATUS_ENABLE
        ])->one();
        
        if($theme){
            return $theme;
        }
        
        return null;
    }
    
    /**
     * Get theme email of edit task
     *
     * @return string|null
     */
    public static function getThemeEditTask(){
    
        $theme = self::find([
                'column_name' => Activity::TYPE_EDIT_TASK,
                'language_code' => \Yii::$app->language,
                'disabled' => self::STATUS_ENABLE
        ])->one();
    
        if($theme){
            return $theme;
        }
    
        return null;
    }

    /**
     * Get theme email of edit task
     *
     * @return string|null
     */
    public static function getThemeCreateTaskPost(){
    
        $theme = self::find([
                'column_name' => Activity::TYPE_CREATE_TASK_POST,
                'language_code' => \Yii::$app->language,
                'disabled' => self::STATUS_ENABLE
        ])->one();
    
        if($theme){
            return $theme;
        }
    
        return null;
    }
        
    /**
     * Get theme email of project post
     * 
     * @param $type
     * @return string|
     */
    public static function getTheme($type) {
        $where = ['language_code' => \Yii::$app->language,];
        switch ($type) {
            case self::INVITE_NEW_EMPLOYEE:
                $where += ['column_name' => self::INVITE_NEW_EMPLOYEE];
                break;
            
            case self::SUCCESS_EMPLOYEE_REGISTRATION:
                $where += ['column_name' => self::SUCCESS_EMPLOYEE_REGISTRATION];
                break;
            
            case self::REQUEST_PASSWORD_AGAIN:
                $where += ['column_name' => self::REQUEST_PASSWORD_AGAIN];
                break;
            
            case self::CREATE_REQUESTMENT:
                $where += ['column_name' => self::CREATE_REQUESTMENT];
                break;
            
            case self::SUCCESS_COMPANY_REGISTRATION:
                $where += ['column_name' => self::SUCCESS_COMPANY_REGISTRATION];
                break;
            
            case self::SUCCESS_COMPANY_REGISTRATION_FREE:
                $where += ['column_name' => self::SUCCESS_COMPANY_REGISTRATION_FREE];
                break;
            default:
                break;
        }
        
        $theme = self::find()->select(['subject', 'body', 'default_from_email'])->where($where)->one();
        if($theme) {
            return $theme;
        }
        
        return '';
    }
}
