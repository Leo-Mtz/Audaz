<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_productos".
 *
 * @property int $id_producto
 * @property int $id_sabor
 * @property int $id_presentacion
 * @property float $precio
 * @property int $cantidad_inventario
 */
class CatProductos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_productos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sabor', 'id_presentacion', 'precio'], 'required'],
            [['id_sabor', 'id_presentacion','cantidad_inventario'], 'integer'],
            [['precio'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_producto' => 'Producto',
            'id_sabor' => 'Sabor',
            'id_presentacion' => 'Presentación',
            'precio' => 'Precio',
            'cantidad_inventario' => 'Inventario',
        ];
    }
	
	public function getSabores()
    {
        return $this->hasOne(CatSabores::className(), ['id_sabor' => 'id_sabor']);
    }
	
	public function getPresentaciones()
    {
        return $this->hasOne(CatPresentaciones::className(), ['id_presentacion' => 'id_presentacion']);
    }

    }
