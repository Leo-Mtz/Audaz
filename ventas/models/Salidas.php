<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salidas".
 *
 * @property int $id_salidas
 * @property int $id_empleado
 * @property string $fecha
 * @property string $id_evento
 * @property int $id_producto
 * @property float $cantidad_vendida
 * @property float $cantidad_degustacion
 * @property float $cantidad_cortesia
 * @property float $cantidad_total
 */
class Salidas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salidas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'id_empleado', 'fecha', 'id_evento', 'id_producto', 'cantidad_vendida', 'cantidad_degustacion', 'cantidad_cortesia', 'cantidad_total'], 'required'],
            [['id_empleado', 'id_producto'], 'integer'],
            [['fecha'], 'safe'],
            [['cantidad_vendida', 'cantidad_degustacion', 'cantidad_cortesia', 'cantidad_total'], 'number'],
            [['id_evento'], 'string', 'max' => 45],
          
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_salidas' => 'Id Salidas',
            'id_empleado' => 'Id Empleado',
            'fecha' => 'Fecha',
            'id_evento' => 'Id Evento',
            'id_producto' => 'Id Producto',
            'cantidad_vendida' => 'Cantidad Vendida',
            'cantidad_degustacion' => 'Cantidad Degustacion',
            'cantidad_cortesia' => 'Cantidad Cortesia',
            'cantidad_total' => 'Cantidad Total',
        ];
    }

    
    public function getEventos()
    {
        return $this->hasOne(CatEventos::className(),['id_evento'=>'id_eventos']);
    }

    public function getEmpleados(){
        return $this->hasOne(CatEmpleados::className(),['id_empleado'=>'id_empleado']);
    }

    public function getProductos(){
        return $this->hasOne(CatProductos::className(),['id_producto'=>'id_producto']);
    }
}
