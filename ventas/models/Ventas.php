<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ventas".
 *
 * @property int $id_venta
 * @property string $fecha
 * @property int|null $id_producto
 * @property float|null $cantidad_vendida
 * @property float|null $precio_total_venta
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
            [['fecha', 'id_evento', 'id_vendedor', 'precio_total_venta', 'cantidad_total_vendida', 'productos_totales', 'forma_de_pago', 'tipo_de_venta'], 'required'],
            [['fecha'], 'safe'],
            [['id_evento', 'id_vendedor'], 'integer'],
            [['precio_total_venta', 'cantidad_total_vendida', 'productos_totales'], 'number'],
            [['forma_de_pago', 'tipo_de_venta'], 'string', 'max' => 255],
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
            'precio_total__venta' => 'Precio Total',
            'id_evento' => 'Id Evento',
            'id_vendedor' => 'Id Vendedor',
            'cantidad_total_vendida' => 'Cantidad Total Vendida',
            'forma_de_pago'=> 'Forma de Pago',
            'tipo_de_venta'=> 'Tipo de Venta',
            'productos_totales' => 'Productos Totales',
            
           
        ];

    }
    public function getProductosPorVenta()
    {
        return $this->hasMany(ProductosPorVenta::className(), ['id_venta' => 'id_venta']);
    }
        public function getNombreSabor()
        {
            return $this->productos ? $this->productos->sabor->nombre : null;
        }
    
        public function getNombrePresentacion()
        {
            return $this->productos ? $this->productos->presentacion->nombre : null;
        }

        public function getEventos()
        {
            return $this->hasOne(CatEventos::className(), ['id_evento' => 'id_evento']);
        }
    

public function beforeValidate()
{
    if ($this->isNewRecord) {
        // Set id_vendedor only if it's a new record
        $this->id_vendedor = Yii::$app->user->identity->id; // Assign the ID of the logged-in user
    }
    
    return parent::beforeValidate();
}

    
   



}
