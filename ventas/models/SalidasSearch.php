<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Salidas;

/**
 * SalidasSearch represents the model behind the search form of `app\models\Salidas`.
 */
class SalidasSearch extends Salidas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_salidas', 'id_empleado',], 'integer'],
            [['fecha', 'id_evento'], 'safe'],
            [['cantidad_vendida', 'cantidad_degustacion', 'cantidad_cortesia', 'cantidad_total'], 'number'],
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
        $query = Salidas::find();

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
            'id_salidas' => $this->id_salidas,
            'id_empleado' => $this->id_empleado,
            'fecha' => $this->fecha,
            'cantidad_vendida' => $this->cantidad_vendida,
            'cantidad_degustacion' => $this->cantidad_degustacion,
            'cantidad_cortesia' => $this->cantidad_cortesia,
            'cantidad_total' => $this->cantidad_total,
        ]);

        $query->andFilterWhere(['like', 'id_evento', $this->id_evento]);

        return $dataProvider;
    }
}
