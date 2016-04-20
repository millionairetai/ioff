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
     * get theme email of creating project 
     */
    public static function getThemeCreateProject(){
        
        $theme = self::find()->andWhere(['column_name' => 'create_project','language_code' => \Yii::$app->language])->one();
        if($theme){
            return $theme;
        }
        return null;
    }
}
