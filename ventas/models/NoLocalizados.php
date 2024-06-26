<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "no_localizados".
 *
 * @property int $id
 * @property string|null $rfc
 * @property string|null $razon_social
 * @property string|null $tipo_persona
 * @property string|null $supuesto
 * @property string|null $fecha_primera_publicacion
 * @property string|null $entidad_federativa
 * @property string|null $fecha_hora_registro
 */
class NoLocalizados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'no_localizados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_primera_publicacion', 'fecha_hora_registro'], 'safe'],
            [['rfc'], 'string', 'max' => 45],
            [['razon_social'], 'string', 'max' => 100],
            [['tipo_persona'], 'string', 'max' => 1],
            [['supuesto'], 'string', 'max' => 10],
            [['entidad_federativa'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rfc' => 'Rfc',
            'razon_social' => 'Razon Social',
            'tipo_persona' => 'Tipo Persona',
            'supuesto' => 'Supuesto',
            'fecha_primera_publicacion' => 'Fecha Primera Publicacion',
            'entidad_federativa' => 'Entidad Federativa',
            'fecha_hora_registro' => 'Fecha Hora Registro',
        ];
    }
}
