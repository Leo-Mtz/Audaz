<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_alertas".
 *
 * @property int $id
 * @property string|null $fecha_hora_alerta
 * @property string|null $correos_alerta
 * @property string|null $correo
 * @property string|null $tipo
 */
class LogAlertas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_alertas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_hora_alerta'], 'safe'],
            [['correos_alerta','correo','tipo'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_hora_alerta' => 'Fecha Hora Alerta',
            'correos_alerta' => 'Correo Alerta',
        ];
    }
}
