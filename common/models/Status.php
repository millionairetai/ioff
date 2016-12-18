<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $description
 * @property string $column_name
 * @property string $owner_table
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Status extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'column_name', 'owner_table'], 'required'],
            [['description'], 'string'],
            [['company_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['column_name', 'owner_table'], 'string', 'max' => 50]
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
            'column_name' => 'Column Name',
            'owner_table' => 'Owner table',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    public static function getStatusName($id){
    	return Status::findOne($id);
    }
    
    /**
     * Get status by owner table and column name
     * 
     * @param string $ownerTable
     * @param string $columnName
     * 
     * @return boolean
     */
    public static function getByOwnerTableAndColumnName($ownerTable, $columnName) {
        return self::find()
                    ->select(['id', 'name', 'owner_table', 'column_name'])
                    ->where(['owner_table' => $ownerTable, 'column_name' => $columnName])
                    ->asArray()
                    ->one();
    }
        
    /**
     * Get status by owner table
     * 
     * param string $ownerTable
     * @return \yii\db\ActiveQuery
     */
    public static function getByOwnerTable($ownerTable) {
        return self::find()
                ->select(['status.id','translation.translated_text AS name'])
                ->leftJoin('translation', 'status.id = translation.owner_id AND translation.owner_table="status"')
                ->leftJoin('language', 'language.id = translation.language_id')
                ->where(['status.owner_table' => $ownerTable, 'language.language_code' => Yii::$app->language])
                ->asArray()
                ->all();
    }
    
    /**
     * Get employee status by id index
     * 
     * param string $ownerTable
     * @return \yii\db\ActiveQuery
     */
    public static function getEmployeesStatus() {
        return self::find()
                ->select(['id','name', 'column_name'])
                ->where(['owner_table' => 'employee'])
                ->indexBy('id')
                ->asArray()
                ->all();;
    }
}
