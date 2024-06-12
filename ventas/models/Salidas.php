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
 * @property string $id_sabor
 * @property float $vendidas_375ml
 * @property float $vendidas_750ml
 * @property float $vendidas_16onz
 * @property float $vendidas_2L
 * @property float $degustacion_375ml
 * @property float $degustacion_16onz
 * @property float $degustacion_750ml
 * @property float $degustacion_2L
 * @property float $cortesia_375ml
 * @property float $cortesia_16onz
 * @property float $cortesia_750ml
 * @property float $cortesia_2L
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
            [[ 'id_empleado', 'fecha', 'id_evento', 'id_sabor', 'cantidad_vendida', 'cantidad_degustacion', 'cantidad_cortesia', 'cantidad_total','vendidas_375ml','vendidas_750ml','vendidas_16onz','vendidas_2L','degustacion_375ml','degustacion_16onz', 'degustacion_750ml','desgutacion_2L', 'cortesia_375ml','cortesia_16onz', 'cortesia_750ml','cortesia_2L'], 'required'],
            [['id_empleado', 'id_evento', 'id_sabor'], 'integer'],
            [['fecha'], 'safe'],
            [[ 'cantidad_vendida', 'cantidad_degustacion', 'cantidad_cortesia', 'cantidad_total','vendidas_375ml','vendidas_750ml','vendidas_16onz','vendidas_2L','degustacion_375ml','degustacion_16onz', 'degustacion_750ml','desgutacion_2L', 'cortesia_375ml','cortesia_16onz', 'cortesia_750ml','cortesia_2L'], 'number'],
          
          
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_salidas' => 'Id Salidas',
            'id_empleado' => 'Empleado',
            'id_sabor' => ' Sabor',
            'fecha' => 'Fecha',
            'id_evento' => 'Evento',
            'cantidad_vendida' => 'Cantidad Vendida',
            'vendidas_375ml' => 'Vendidas 375ml',
            'vendidas_750ml' => 'Vendidas 750ml',
            'vendidas_16onz' => 'Vendidas 16onz',
            'vendidas_2L' => 'Vendidas 2L',
            'cantidad_degustacion' => 'Cantidad Degustacion',
            'degustacion_375ml' => 'Degustacion 375ml',
            'degustacion_16onz' => 'Degustacion 16onz',
            'degustacion_750ml' => 'Degustacion 750ml',
            'degustacion_2L' => 'Degustacion 2L',
            'cantidad_cortesia' => 'Cantidad Cortesia',
            'cortesia_375ml' => 'Cortesia 375ml',
            'cortesia_16onz' => 'Cortesia 16onz',
            'cortesia_750ml' => 'Cortesia 750ml',
            'cortesia_2L' => 'Cortesia 2L',
            'cantidad_total' => 'Cantidad Total',
        ];
    }

    
    public function getEventos()
    {
        return $this->hasOne(CatEventos::className(),['id_evento'=>'id_evento']);
    }

    public function getEmpleados(){
        return $this->hasOne(CatEmpleados::className(),['id_empleado'=>'id_empleado']);
    }

    public function getSabores(){
        return $this->hasOne(CatSabores::className(),['id_sabor'=>'id_sabor']);
    }
 
}
