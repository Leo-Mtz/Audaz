<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatProductos;

/**
 * CatProductosSearch represents the model behind the search form of `app\models\CatProductos`.
 */
class CatProductosSearch extends CatProductos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_producto', 'id_sabor', 'id_presentacion'], 'integer'],
            [['precio'], 'number'],
            [['cantidad_inventario'], 'integer'],
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
        $query = CatProductos::find()
            ->joinWith(['sabores', 'presentaciones'])
            ->select(['cat_productos.*', 'cat_sabores.sabor AS sabor_nombre', 'cat_presentaciones.presentacion AS presentacion_nombre']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'sabor_nombre' => [
                        'asc' => ['cat_sabores.sabor' => SORT_ASC],
                        'desc' => ['cat_sabores.sabor' => SORT_DESC],
                    ],
                    'presentacion_nombre' => [
                        'asc' => ['cat_presentaciones.presentacion' => SORT_ASC],
                        'desc' => ['cat_presentaciones.presentacion' => SORT_DESC],
                    ],
                    'precio',
                    'cantidad_inventario',
                ],
                'defaultOrder' => [
                    'sabor_nombre' => SORT_ASC,
                    'presentacion_nombre' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_producto' => $this->id_producto,
            'id_sabor' => $this->id_sabor,
            'id_presentacion' => $this->id_presentacion,
            'precio' => $this->precio,
            'cantidad_inventario' => $this->cantidad_inventario,
        ]);

        return $dataProvider;
    }
}
