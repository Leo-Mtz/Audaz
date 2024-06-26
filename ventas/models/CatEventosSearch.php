<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatEventos;

/**
 * CatEventosSearch represents the model behind the search form of `app\models\CatEventos`.
 */
class CatEventosSearch extends CatEventos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_evento'], 'integer'],
            [['evento', 'fecha_inicio', 'fecha_termino'], 'safe'],
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
        $query = CatEventos::find();

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
            'id_evento' => $this->id_evento,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_termino' => $this->fecha_termino,
        ]);

        $query->andFilterWhere(['like', 'evento', $this->evento]);

        return $dataProvider;
    }
}
