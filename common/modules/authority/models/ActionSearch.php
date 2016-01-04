<?php

namespace common\modules\authority\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\authority\models\Action;

/**
 * ActionSearch represents the model behind the search form about `common\modules\authority\models\Action`.
 */
class ActionSearch extends Action
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'controller_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['name', 'description', 'url'], 'safe'],
            [['is_display_menu', 'disabled'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Action::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'controller_id' => $this->controller_id,
            'is_display_menu' => $this->is_display_menu,
            'datetime_created' => $this->datetime_created,
            'lastup_datetime' => $this->lastup_datetime,
            'lastup_employee_id' => $this->lastup_employee_id,
//            'disabled' => $this->disabled,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
