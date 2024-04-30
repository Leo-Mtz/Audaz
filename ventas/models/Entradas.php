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
 * @property int $id_producto
 * @property float|null $cantidad_entradas
 */
class Entradas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entradas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_entradas', 'fecha', 'id_empleado', 'id_evento', 'id_producto'], 'required'],
            [['id_entradas', 'id_empleado', 'id_evento', 'id_producto'], 'integer'],
            [['fecha'], 'safe'],
            [['cantidad_entradas'], 'number'],
            [['id_entradas'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_entradas' => 'Num de Entrada',
            'fecha' => 'Fecha',
            'id_empleado' => 'Id Empleado',
            'id_evento' => 'Id Evento',
            'id_producto' => 'Id Producto',
            'cantidad_entradas' => 'Cantidad Entradas',
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
