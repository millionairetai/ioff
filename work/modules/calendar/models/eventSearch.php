<?php
/**
 * @author minh-tha
 * @create date 2016-01-06
 */
namespace work\modules\calendar\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\work\event;

/**
 * eventSearch represents the model behind the search form about `common\models\calendar\event`.
 */
class eventSearch extends event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'calendar_id', 'employee_id', 'start_datetime', 'end_datetime', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['name', 'description', 'description_parse', 'address'], 'safe'],
            [['is_public', 'disabled'], 'boolean'],
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
        $query = event::find();

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
            'calendar_id' => $this->calendar_id,
            'employee_id' => $this->employee_id,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'is_public' => $this->is_public,
            'datetime_created' => $this->datetime_created,
            'lastup_datetime' => $this->lastup_datetime,
            'lastup_employee_id' => $this->lastup_employee_id,
            'disabled' => $this->disabled,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'description_parse', $this->description_parse])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
