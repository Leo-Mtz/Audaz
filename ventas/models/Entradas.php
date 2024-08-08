<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entradas".
 *
 * @property int $id_entradas
 * @property string $fecha
 * @property int $id_empleado
 * @property int $id_evento
 * @property double|null $cantidad_entradas
 * @property double $entradas_totales
 * @property double $entradas_producto
 */
class Entradas extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'entradas';
    }

    public function rules()
    {
        return [
            [['fecha', 'id_empleado', 'id_evento', 'entradas_totales'], 'required'],
            [['fecha'], 'safe'],
            [['id_empleado', 'id_evento'], 'integer'],
            [['cantidad_entradas', 'entradas_totales'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_entradas' => 'ID',
            'fecha' => 'Fecha',
            'id_empleado' => 'Empleado',
            'id_evento' => 'Evento',
            'cantidad_entradas' => 'Cantidad Entradas',
            'entradas_totales' => 'Entradas Totales',
        ];
    }



    public function getEventos()
    {
        return $this->hasOne(CatEventos::className(), ['id_evento' => 'id_evento']);
    }

    public function getEmpleados()
    {
        return $this->hasOne(CatEmpleados::className(), ['id_empleado' => 'id_empleado']);
    }

    
    public function getProductosPorEntradas()
    {
        return $this->hasMany(ProductosPorEntradas::className(), ['id_entradas' => 'id_entradas']);
    }


   

}

