<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "translation".
 *
 * @property integer $id
 * @property integer $languague_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $translated_text
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property integer $disabled
 */
class Translation extends \backend\components\db\ActiveRecord
{
    public $language_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_table'], 'required'],
            [['owner_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id', 'disabled'], 'integer'],
            [['owner_table'], 'string', 'max' => 50],
            [['translated_text'], 'string', 'max' => 255],
            [['language_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'languague_id' => Yii::t('common', 'Language'),
            'owner_id' => Yii::t('common', 'Owner'),
            'owner_table' => Yii::t('backend', 'Owner Table'),
            'translated_text' => Yii::t('backend', 'Translated text'),
            'datetime_created' => Yii::t('common', 'Datetime Created'),
            'lastup_datetime' => Yii::t('common', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('common', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('common', 'Lastup Employee ID'),
            'disabled' => Yii::t('common', 'Disabled'),
            'language_name' => Yii::t('common', 'Language'),
        ];
    }
    
    /**
     * Get all task follow employess login
     */
    public static function getByParams($params) {
        return self::find()
                        ->select(['owner_id', 'owner_table', 'translated_text'])
                        ->where($params)
//                        ->asArray()
                        ->one();
    }
    
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = static::find()
                ->select(['translated_text', 'owner_table', 'translation.id', 'translation.id', 'language.name as language_name'])
                ->leftJoin('controller', 'translation.owner_id=controller.id AND owner_table="controller"')
                ->leftJoin('action', 'translation.owner_id=action.id AND owner_table="action"')
                ->leftJoin('language', 'translation.language_id=language.id');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => self::PAGE_SIZE)
        ]);
        
        if (!($this->load($params))) {
            return $dataProvider;
        }
        
//        $query->andFilterWhere(['like', 'column_name', $this->column_name]);
        $query->andFilterWhere(['like', 'owner_table', $this->owner_table]);
        $query->andFilterWhere(['like', 'translated_text', $this->translated_text]);
        
        return $dataProvider;
    }
}
