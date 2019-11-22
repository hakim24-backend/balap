<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HeatOne;

/**
 * HeatOneSearch represents the model behind the search form of `common\models\HeatOne`.
 */
class HeatOneSearch extends HeatOne
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['POSISI', 'NO_START', 'KELAS'], 'integer'],
            [['NAMA', 'TEAM', 'KENDARAAN', 'KOTA','RT','ET60', 'ET', 'SPEED', 'TIME'], 'safe'],
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
    public function search($params, $id = null)
    {
        if($id == null)
        {
               $query = HeatOne::find();
        
        }else{
            $query = HeatOne::find()->where(['KELAS' => $id]);
        }
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
            'POSISI' => $this->POSISI,
            'NO_START' => $this->NO_START,
            'KELAS' => $this->KELAS,
        ]);

        $query->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'TEAM', $this->TEAM])
            ->andFilterWhere(['like', 'KENDARAAN', $this->KENDARAAN])
            ->andFilterWhere(['like', 'RT', $this->RT])
            ->andFilterWhere(['like', 'ET60', $this->ET60])
            ->andFilterWhere(['like', 'ET', $this->ET])
            ->andFilterWhere(['like', 'SPEED', $this->SPEED])
            ->andFilterWhere(['like', 'SPEED', $this->SPEED])
            ->andFilterWhere(['like', 'KOTA', $this->KOTA]);

        return $dataProvider;
    }
}
