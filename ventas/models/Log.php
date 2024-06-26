<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int|null $usuario
 * @property string|null $fecha_hora_acceso
 * @property string|null $fecha_hora_fin
 * @property string|null $accion ALTA-BAJA-ACTUALIZACION
 * @property string|null $hizo
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario'], 'integer'],
            [['fecha_hora_acceso', 'fecha_hora_fin'], 'safe'],
            [['hizo'], 'string'],
            [['accion'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'fecha_hora_acceso' => 'Fecha Hora Acceso',
            'fecha_hora_fin' => 'Fecha Hora Fin',
            'accion' => 'Accion',
            'hizo' => 'Hizo',
        ];
    }
}
