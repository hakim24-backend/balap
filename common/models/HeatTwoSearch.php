<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HeatTwo;

/**
 * HeatTwoSearch represents the model behind the search form of `common\models\HeatTwo`.
 */
class HeatTwoSearch extends HeatTwo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['POSISI', 'NO_START', 'KELAS', 'ID_OLD'], 'integer'],
            [['NAMA', 'TEAM', 'KENDARAAN', 'KOTA'], 'safe'],
            [['RT', 'ET60', 'ET', 'SPEED', 'TIME'], 'number'],
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
    public function search($params, $id)
    {
        if($id == null)
        {
               $query = HeatTwo::find();
        
        }else{
            $query = HeatTwo::find()->where(['KELAS' => $id]);
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
            'RT' => $this->RT,
            'ET60' => $this->ET60,
            'ET' => $this->ET,
            'SPEED' => $this->SPEED,
            'TIME' => $this->TIME,
            'ID_OLD' => $this->ID_OLD,
        ]);

        $query->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'TEAM', $this->TEAM])
            ->andFilterWhere(['like', 'KENDARAAN', $this->KENDARAAN])
            ->andFilterWhere(['like', 'KOTA', $this->KOTA]);

        return $dataProvider;
    }
}
