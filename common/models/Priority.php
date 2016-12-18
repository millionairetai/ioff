<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "priority".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $description
 * @property string $owner_table
 * @property string $column_name
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Priority extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'priority';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'datetime_created', 'owner_table', 'column_name', 'lastup_datetime', 'lastup_employee_id'], 'required'],
            [['description'], 'string'],
            [['company_id','datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['owner_table', 'column_name',], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company id',
            'name' => 'Name',
            'description' => 'Description',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    public static function getPriorityName($id){
    	return Priority::findOne($id);
    }
        
    /**
     * Get priority by owner table
     * 
     * param string $ownerTable
     * @return \yii\db\ActiveQuery
     */
    public static function getByOwnerTable($ownerTable) {
        return self::find()
                ->select(['priority.id','translation.translated_text AS name'])
                ->leftJoin('translation', 'priority.id = translation.owner_id AND translation.owner_table="priority"')
                ->leftJoin('language', 'language.id = translation.language_id')
                ->where(['priority.owner_table' => $ownerTable, 'language.language_code' => Yii::$app->language])
                ->asArray()
                ->all();;
    }
}
