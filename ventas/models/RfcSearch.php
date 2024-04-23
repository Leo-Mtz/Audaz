<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rfc;

/**
 * RfcSearch represents the model behind the search form of `app\models\Rfc`.
 */
class RfcSearch extends Rfc
{
    /**
     * {@inheritdoc}
     */
	public $patente;
	
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['rfc', 'razon_social', 'patente', 'agente_aduanal', 'descripcion','borrado'], 'safe'],
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
        $query = Rfc::find();
		$query->joinWith(['patentes']);

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
        ]);

        $query->andFilterWhere(['like', 'rfc', $this->rfc])
            ->andFilterWhere(['like', 'razon_social', $this->razon_social])
			->andFilterWhere(['like', 'cat_patentes.patente', $this->patente])
            ->andFilterWhere(['like', 'agente_aduanal', $this->agente_aduanal])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'borrado', $this->borrado]);

        return $dataProvider;
    }
}
