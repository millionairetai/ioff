<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Company;
use yii\data\ActiveDataProvider;

class CompanySearch extends Company {

    public function rules() {
        // only fields in rules() are searchable
        return [
            [['status_id', 'plan_type_id'], 'integer'],
            [['name', 'email', 'phone_no', 'language_code'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 99],
            [['phone_no'], 'string', 'max' => 50],
            [['plan_type_name'], 'integer',],
        ];
    }

    public function scenarios() {
// bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = static::find()
                ->select(['company.*', 'plan_type.name as plan_type_name'])
                ->joinWith(['status'])
                ->joinWith(['plan_type']);
//                ->orderBy('datetime_created DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10)
        ]);
        if (!($this->load($params))) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'company.name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'address', $this->address]);
        $query->andFilterWhere(['like', 'phone_no', $this->phone_no]);
        $query->andFilterWhere(['like', 'max_user_register', $this->max_user_register]);
        $query->andFilterWhere(['like', 'max_storage_register', $this->max_storage_register]);
        $query->andFilterWhere(['like', 'plan_type.name', $this->plan_type_name]);
//        $query->orFilterWhere(['like', 'domain', $this->domain]);

        return $dataProvider;
    }

}
