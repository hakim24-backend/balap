<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Bracket;

/**
 * BracketSearch represents the model behind the search form of `common\models\Bracket`.
 */
class BracketSearch extends Bracket
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama_bracket'], 'safe'],
            [['batas_atas', 'batas_bawah'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Bracket::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'batas_atas' => $this->batas_atas,
            'batas_bawah' => $this->batas_bawah,
        ]);

        $query->andFilterWhere(['like', 'nama_bracket', $this->nama_bracket]);

        return $dataProvider;
    }
}
