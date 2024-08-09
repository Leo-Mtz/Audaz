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
 * @property double $entradas_totales
 * 
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

    // En Entradas.php
public function getIdProducto()
{
    // Lógica para obtener el ID del producto basado en otros atributos del modelo
    $producto = CatProductos::find()
        ->where(['id_sabor' => $this->id_sabor, 'id_presentacion' => $this->id_presentacion])
        ->one();

    if ($producto) {
        return $producto->id_producto;
    }

    return null;
}

public function updateInventory()
{
    $idProducto = $this->getIdProducto();
    if ($idProducto !== null) {
        $producto = CatProductos::findOne($idProducto);
        if ($producto) {
            $producto->cantidad_inventario += $this->cantidad_entradas_producto;
            if (!$producto->save(false)) {
                // Manejar el error si el guardado falla
                throw new \Exception('Error al actualizar el inventario del producto.');
            }
        }
    }
}

public function afterSave($insert, $changedAttributes)
{
    parent::afterSave($insert, $changedAttributes);

    if (!$insert) {
        // Solo actualiza el inventario si es una actualización
        $this->updateInventory();
    }
}






}

