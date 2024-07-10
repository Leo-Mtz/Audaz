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
}
