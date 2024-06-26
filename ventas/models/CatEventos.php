<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_eventos".
 *
 * @property int $id_evento
 * @property string $evento
 * @property string $fecha_inicio
 * @property string $fecha_termino
 */
class CatEventos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_eventos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evento', 'fecha_inicio', 'fecha_termino'], 'required'],
            [['fecha_inicio', 'fecha_termino'], 'safe'],
            [['evento'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_evento' => 'Id Evento',
            'evento' => 'Evento',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_termino' => 'Fecha Termino',
        ];
    }
}
