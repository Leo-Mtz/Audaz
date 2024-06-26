<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Firmes;

/**
 * FirmesSearch represents the model behind the search form of `app\models\Firmes`.
 */
class FirmesSearch extends Firmes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['rfc', 'razon_social', 'tipo_persona', 'supuesto', 'fecha_primera_publicacion', 'entidad_federativa', 'fecha_hora_registro'], 'safe'],
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
        $query = Firmes::find();

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
            'fecha_primera_publicacion' => $this->fecha_primera_publicacion,
            'fecha_hora_registro' => $this->fecha_hora_registro,
        ]);

        $query->andFilterWhere(['like', 'rfc', $this->rfc])
            ->andFilterWhere(['like', 'razon_social', $this->razon_social])
            ->andFilterWhere(['like', 'tipo_persona', $this->tipo_persona])
            ->andFilterWhere(['like', 'supuesto', $this->supuesto])
            ->andFilterWhere(['like', 'entidad_federativa', $this->entidad_federativa]);

        return $dataProvider;
    }
}
