<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Salidas;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * SalidasSearch represents the model behind the search form of `app\models\Salidas`.
 */
class SalidasSearch extends Salidas
{
    public function rules()
    {
        return [
            [['id_salidas', 'id_empleado', 'id_evento', 'id_sabor'], 'integer'],
            [['fecha'], 'safe'],
            [['cantidad_vendida', 'cantidad_degustacion', 'cantidad_cortesia', 'cantidad_total'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Salidas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // Grid filtering conditions
        $query->andFilterWhere([
            'id_salidas' => $this->id_salidas,
            'id_empleado' => $this->id_empleado,
            'id_evento' => $this->id_evento,
            'id_sabor' => $this->id_sabor,
            'fecha' => $this->fecha,
            'cantidad_vendida' => $this->cantidad_vendida,
            'cantidad_degustacion' => $this->cantidad_degustacion,
            'cantidad_cortesia' => $this->cantidad_cortesia,
            'cantidad_total' => $this->cantidad_total,
        ]);

        return $dataProvider;
    }
}
?>