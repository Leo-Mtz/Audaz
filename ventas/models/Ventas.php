<?php

namespace app\models;

use Yii;

use app\Models\CatProductos;


/**
 * This is the model class for table "ventas".
 *
 * @property int $id_venta
 * @property string $fecha
 * @property int|null $id_producto
 * @property float|null $cantidad_vendida
 * @property float|null $precio_total_venta
 * @property string|null $precio_unitario
 * @property string|null $cantidad_total_vendida
 * @property int|null $id_evento
 * @property int|null $id_vendedor
 */
class Ventas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ventas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'id_evento', 'id_vendedor', 'id_producto','precio_unitario','precio_total_producto', 'cantidad_vendida','cantidad_total_vendida', 'precio_total_venta'], 'required'],
            [['fecha'], 'safe'],
            [['id_producto', 'id_evento', 'id_vendedor'], 'integer'],
            [['cantidad_vendida', 'precio_unitario','precio_total_venta','precio_total_producto', 'cantidad_total_vendida'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()

    {
        return [
            'id_venta' => 'Id Venta',
            'fecha' => 'Fecha',
            'id_producto' => 'Producto',
            'cantidad_vendida' => 'Cantidad Vendida',
            'precio_total__venta' => 'Precio Total',
            'id_evento' => 'Id Evento',
            'id_vendedor' => 'Id Vendedor',
        ];

    }
        public function getProductos(){
            //establece relacion entre ventas y productos
            return $this->hasOne(CatProductos::className(), ['id_producto' => 'id_producto']);
        }

        public function getNombreSabor()
        {
            return $this->productos ? $this->productos->sabor->nombre : null;
        }
    
        public function getNombrePresentacion()
        {
            return $this->productos ? $this->productos->presentacion->nombre : null;
        }


public function beforeValidate()
{
    if ($this->isNewRecord) {
        // Set id_vendedor only if it's a new record
        $this->id_vendedor = Yii::$app->user->identity->id; // Assign the ID of the logged-in user
    }
    
    var_dump($this->id_vendedor); // Display the value of id_vendedor
    
    return parent::beforeValidate();
}



    
public function getPrecioUnitario($id_producto)
{
    if ($this->productos === null) {
        return null;
    }

    $producto = $this->productos->findOne($id_producto);

    if ($producto === null) {
        return null;
    }

    return $producto->precio;
}
}
    
    

