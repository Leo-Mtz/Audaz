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
 * @property float|null $precio_total
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
            [['fecha', 'id_evento', 'id_vendedor', 'id_producto', 'cantidad_vendida', 'precio_total'], 'required'],
            [['fecha'], 'safe'],
            [['id_producto', 'id_evento', 'id_vendedor'], 'integer'],
            [['cantidad_vendida', 'precio_total'], 'number'],
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
            'id_producto' => 'Id Producto',
            'cantidad_vendida' => 'Cantidad Vendida',
            'precio_total' => 'Precio Total',
            'id_evento' => 'Id Evento',
            'id_vendedor' => 'Id Vendedor',
        ];

    }
        public function getProductos(){
            return $this->hasOne(Productos::className(), ['id_producto' => 'id_producto']);
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
    

