<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ventas".
 *
 * @property int $id_venta The unique identifier for the sale.
 * @property string $fecha The date of the sale.
 * @property int|null $id_producto The ID of the product sold (if applicable).
 * @property float|null $cantidad_vendida The quantity of product sold (if applicable).
 * @property float|null $precio_total_venta The total price of the sale.
 * @property int|null $id_evento The ID of the event associated with the sale (if applicable).
 * @property int|null $id_vendedor The ID of the vendor making the sale (if applicable).
 * @property string|null $forma_de_pago The payment method used for the sale (if applicable).
 * @property string|null $tipo_de_venta The type of sale (if applicable).
 */
class Ventas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     * Defines the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'ventas';
    }

    /**
     * {@inheritdoc}
     * Defines the validation rules for the attributes.
     */
    public function rules()
    {
        return [
            [['fecha', 'id_evento', 'id_vendedor', 'precio_total_venta', 'cantidad_total_vendida', 'productos_totales', 'forma_de_pago', 'tipo_de_venta'], 'required'],
            [['fecha'], 'safe'],
            [['id_evento', 'id_vendedor'], 'integer'],
            [['precio_total_venta', 'cantidad_total_vendida', 'productos_totales'], 'number'],
            [['forma_de_pago', 'tipo_de_venta'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     * Provides labels for the attributes.
     */
    public function attributeLabels()
    {
        return [
            'id_venta' => 'Id Venta',
            'fecha' => 'Fecha',
            'precio_total__venta' => 'Precio Total',
            'id_evento' => 'Id Evento',
            'id_vendedor' => 'Id Vendedor',
            'cantidad_total_vendida' => 'Cantidad Total Vendida',
            'forma_de_pago'=> 'Forma de Pago',
            'tipo_de_venta'=> 'Tipo de Venta',
            'productos_totales' => 'Productos Totales',
        ];
    }

    /**
     * Gets the related ProductosPorVenta models.
     * @return \yii\db\ActiveQuery
     */

   
     /* Establece una relacion one-to-many (uno a varios ) entre el modelo de ventas y el modelo de ProductosPorVenta.
    significa que una venta puede tener diferentes productos, la relación se define por medio del 'id_venta' que ambas tablas comparten.*/
    public function getProductosPorVenta()
    {
        return $this->hasMany(ProductosPorVenta::className(), ['id_venta' => 'id_venta']);
    }

    /**
     * Gets the name of the flavor of the product.
     * @return string|null
     */

     /*Obtiene el nombre del sabor del producto.*/
    public function getNombreSabor()
    {
        return $this->productos ? $this->productos->sabor->nombre : null;
    }

    /**
     * Gets the name of the presentation of the product.
     * @return string|null
     */

    /*Obtiene el nombre de la presentacion del producto.*/
    public function getNombrePresentacion()
    {
        return $this->productos ? $this->productos->presentacion->nombre : null;
    }

    /**
     * Gets the related CatEventos model.
     * @return \yii\db\ActiveQuery
     */


     /*Establece una relación uno a uno con el modelo de CatEventos, el cual permite relacionar una venta con un evento.*/

    public function getEventos()
    {
        return $this->hasOne(CatEventos::className(), ['id_evento' => 'id_evento']);
    }

    /**
     * This method is invoked before validation starts.
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            // Set id_vendedor only if it's a new record
            $this->id_vendedor = Yii::$app->user->identity->id; // Assign the ID of the logged-in user
        }
        
        return parent::beforeValidate();
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
