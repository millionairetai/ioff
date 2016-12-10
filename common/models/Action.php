<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Controller;

/**
 * This is the model class for table "action".
 *
 * @property integer $id
 * @property integer $controller_id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property boolean $is_display_menu
 * @property boolean $is_check
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Action extends \backend\components\db\ActiveRecord {

    public $controller_column_name;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'action';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['controller_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['column_name'], 'required'],
            [['description', 'url', 'controller_column_name'], 'string'],
            [['is_display_menu', 'disabled', 'is_check'], 'boolean'],
            [['column_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'controller_id' => Yii::t('backend', 'Controller ID'),
            'name' => Yii::t('backend', 'Name'),
            'description' => Yii::t('backend', 'Description'),
            'url' => Yii::t('backend', 'Url'),
            'is_display_menu' => Yii::t('backend', 'Is Display Menu'),
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
        $query = self::find()
                ->select(['action.id', 'url', 'is_display_menu', 'is_check', 'package_name', 'action.description', 
                    'action.column_name', 'controller.column_name AS controller_column_name'])
                ->leftJoin('controller', 'controller.id=action.controller_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => self::PAGE_SIZE)
        ]);

        if (!($this->load($params))) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'controller.column_name', $this->controller_column_name]);
        $query->andFilterWhere(['like', 'action.column_name', $this->column_name]);
        $query->andFilterWhere(['like', 'action.description', $this->description]);

        return $dataProvider;
    }

}
