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
            [['fecha', 'id_empleado', 'id_evento', 'id_producto'], 'required'],
            [['id_empleado', 'id_evento', 'id_producto'], 'integer'],
            [['fecha'], 'safe'],
            [['cantidad_entradas'], 'number'],
          
        ];
    
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_entradas' => 'Entrada',
            'fecha' => 'Fecha',
            'id_empleado' => 'Id Empleado',
            'id_evento' => 'Id Evento',
            'id_producto' => 'Producto',
            'cantidad_entradas' => 'Cantidad Entradas',
        ];
    }

    public function getEventos()
    {
        return $this->hasOne(CatEventos::className(),['id_evento'=>'id_evento']);
    }

    public function getEmpleados(){
        return $this->hasOne(CatEmpleados::className(),['id_empleado'=>'id_empleado']);
    }

    
    public function getProductos(){
        return $this->hasOne(CatProductos::className(),['id_producto'=>'id_producto']);
    }

   
    public function getNombreSabor()
    {
        return $this->productos ? $this->productos->sabor->nombre : null;
    }

    public function getNombrePresentacion()
    {
        return $this->productos ? $this->productos->presentacion->nombre : null;
    }
}
