<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ventas;

/**
 * VentasSearch represents the model behind the search form of `app\models\Ventas`.
 */
class VentasSearch extends Ventas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_venta', 'id_producto', 'id_evento', 'id_vendedor'], 'integer'],
            [['fecha'], 'safe'],
            [['cantidad_vendida', 'precio_total'], 'number'],
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
        $query = Ventas::find();

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
            'id_venta' => $this->id_venta,
            'fecha' => $this->fecha,
            'id_producto' => $this->id_producto,
            'cantidad_vendida' => $this->cantidad_vendida,
            'precio_total' => $this->precio_total,
            'id_evento' => $this->id_evento,
            'id_vendedor' => $this->id_vendedor,
        ]);

        return $dataProvider;
    }
}
