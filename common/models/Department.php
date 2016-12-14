<?php

namespace common\models;

use common\components\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $description
 * @property integer $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Department extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['company_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('common', 'ID'),
            'company_id' 		 => Yii::t('common', 'Company id'),
            'name' 				 => Yii::t('common', 'Name'),
            'description' 		 => Yii::t('common', 'Description'),
            'datetime_created' 	 => Yii::t('common', 'Datetime Created'),
            'lastup_datetime'	 => Yii::t('common', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' 			 => Yii::t('common', 'Disabled'),
        ];
    }
    
    
    /**
     * Get all department
     * 
     * @param interger $itemPerPage
     * @param interger $currentPage
     * @return array
     */
    public static function gets($itemPerPage, $currentPage) {
        $departments = self::find()->select(['id', 'name'])->andCompanyId();
        $totalCount = $departments->count();
        $departments = $departments->orderBy('datetime_created DESC')
                ->limit($itemPerPage)
                ->offset(($currentPage - 1) * $itemPerPage)
                ->asArray()->all();

        return [
            'collection' => $departments,
            'totalItems' => $totalCount,
        ];
    }   
    
    /**
     * Get department by name
     *
     * @param string $name
     * @return Active Record|false
     */
    public static function getByName($name) {
        return self::find()->andWhere(['name' => $name])->andCompanyId()->one();
    }
}
