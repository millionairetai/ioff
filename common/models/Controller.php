<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "controller".
 *
 * @property integer $id
 * @property integer $package_id
 * @property string $name
 * @property string $description
 * @property string $package_name
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Controller extends \backend\components\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'controller';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['package_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [[ 'package_id', 'column_name'], 'required'],
            [['disabled'], 'boolean'],
            [['column_name', 'description'], 'string', 'max' => 255],
            [['package_name'], 'string', 'max' => 50],//!!!
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'package_id' => Yii::t('backend', 'Package'),
            'column name' => Yii::t('backend', 'Column name'),
            'description' => Yii::t('backend', 'Description'),
            'package_name' => Yii::t('backend', 'Package Name'),
            'datetime_created' => Yii::t('backend', 'Datetime Created'),
            'lastup_datetime' => Yii::t('backend', 'Lastup Datetime'),
            'created_employee_id' => Yii::t('backend', 'Created Employee ID'),
            'lastup_employee_id' => Yii::t('backend', 'Lastup Employee ID'),
            'disabled' => Yii::t('backend', 'Disabled'),
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = static::find()
                ->select(['controller.id', 'package_name', 'description', 'column_name'])
                ->leftJoin('translation', 'translation.owner_id=controller.id AND owner_table="controller"');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => self::PAGE_SIZE)
        ]);
        if (!($this->load($params))) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'column_name', $this->column_name]);
        $query->andFilterWhere(['like', 'package_name', $this->package_name]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}
