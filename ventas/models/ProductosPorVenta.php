<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_por_venta".
 *
 * @property int $id
 * @property int $id_venta
 * @property int $id_producto
 * @property float $cantidad_vendida
 * @property float $precio_unitario
 * @property float $subtotal_producto
 *
 * @property Ventas $venta
 * @property CatProductos $producto
 */
class ProductosPorVenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_por_venta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_venta', 'id_producto', 'cantidad_vendida', 'subtotal_producto'], 'required'],
            [['id_venta', 'id_producto'], 'integer'],
            [['cantidad_vendida', 'precio_unitario', 'subtotal_producto'], 'number'],
            [['id_venta'], 'exist', 'skipOnError' => true, 'targetClass' => Ventas::className(), 'targetAttribute' => ['id_venta' => 'id_venta']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => CatProductos::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_venta' => 'Id Venta',
            'id_producto' => 'Id Producto',
            'cantidad_vendida' => 'Cantidad Vendida',
            'precio_unitario' => 'Precio Unitario',
            'subtotal_producto' => 'Subtotal Producto',
        ];
    }

    /**
     * Gets query for [[Venta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenta()
    {
        return $this->hasOne(Ventas::className(), ['id_venta' => 'id_venta']);
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(CatProductos::className(), ['id_producto' => 'id_producto']);
    }

    
    public function afterSave($insert, $changedAttributes)
{
    parent::afterSave($insert, $changedAttributes);

    if (!$insert) {
        // Handle case when updating
        $this->updateInventory();
    }
}

public function updateInventory()
{
    // Find all related ProductosPorVenta records
    $productosPorVenta = ProductosPorVenta::findAll(['id_venta' => $this->id_venta]);

    foreach ($productosPorVenta as $productoPorVenta) {
        $producto = CatProductos::findOne($productoPorVenta->id_producto);

        if ($producto) {
            // Subtract the cantidad_vendida from cantidad_inventario
            $producto->cantidad_inventario -= $productoPorVenta->cantidad_vendida;
            
            // Save the updated product inventory
            if (!$producto->save(false)) {
                Yii::debug($producto->errors, 'producto_inventory_errors');
            }
        }
    }
}
public function validateInventory()
{
    $productosPorVenta = ProductosPorVenta::findAll(['id_venta' => $this->id_venta]);

    foreach ($productosPorVenta as $productoPorVenta) {
        $producto = CatProductos::findOne($productoPorVenta->id_producto);

        if ($producto && $productoPorVenta->cantidad_vendida > $producto->cantidad_inventario) {
            $this->addError('productos', 'No hay suficiente inventario  ' . $productoPorVenta->id_producto);
            return false;
        }
    }

    return true;
}


}
