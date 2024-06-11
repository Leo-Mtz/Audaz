<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Entradas;

/**
 * EntradasSearch represents the model behind the search form of `app\models\Entradas`.
 */
class EntradasSearch extends Entradas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['id_entradas', 'id_empleado', 'id_evento', 'id_sabor'], 'integer'],
            [['fecha'], 'safe'],
            [['cantidad_entradas'], 'number'],
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
        $query = Entradas::find();

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
            'id_entradas' => $this->id_entradas,
            'fecha' => $this->fecha,
            'id_empleado' => $this->id_empleado,
            'id_evento' => $this->id_evento,
            'id_sabor' => $this->id_sabor,
            'cantidad_entradas' => $this->cantidad_entradas,
        ]);

        return $dataProvider;
    }
}
