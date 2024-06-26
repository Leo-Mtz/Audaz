<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rfc".
 *
 * @property int $id
 * @property string|null $rfc
 * @property string|null $razon_social
 * @property string|null $patente
 * @property string|null $agente_aduanal
 * @property string|null $descripcion
 * @property string|null $borrado
 */
class Rfc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rfc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['rfc','razon_social','agente_aduanal','descripcion'], 'required'],
            [['descripcion'], 'string'],
            [['rfc'], 'unique','message' => 'El rfc ya esta registrado'],
            [['razon_social', 'agente_aduanal'], 'string', 'max' => 200],
            [['patente'], 'string', 'max' => 4],
            [['rfc'], 'string', 'max' => 14],
            [['borrado'], 'string', 'max' => 1],
			[['patente'], 'required','message' => 'Seleccionar una patente'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'razon_social' => 'Razon Social',
            'patente' => 'Patente',
            'agente_aduanal' => 'Agente Aduanal',
            'descripcion' => 'Descripcion',
            'rfc' => 'RFC',
            'borrado' => 'Estatus',
        ];
    }
	
	public function getPatentes()
	{
		return $this->hasOne(CatPatentes::className(),['id' => 'patente']);
	}
}
