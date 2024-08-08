<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_por_entradas".
 *
 * @property int $id
 * @property int $id_entradas
 * @property int $id_sabor
 * @property int $id_presentacion
 * @property int $id_producto
 * @property int $cantidad_entradas_producto
 *
 * @property Entradas $entrada
 * @property CatProductos $producto
 * @property CatSabores $sabor
 * @property CatPresentaciones $presentacion
 */
class ProductosPorEntradas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_por_entradas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_entradas', 'id_sabor', 'id_presentacion', 'id_producto', 'cantidad_entradas_producto'], 'required'],
            [['id_entradas', 'id_sabor', 'id_presentacion', 'id_producto'], 'integer'],
            [['cantidad_entradas_producto'], 'number'],
            [['id_entradas'], 'exist', 'skipOnError' => true, 'targetClass' => Entradas::className(), 'targetAttribute' => ['id_entradas' => 'id_entradas']],
            [['id_sabor'], 'exist', 'skipOnError' => true, 'targetClass' => CatSabores::className(), 'targetAttribute' => ['id_sabor' => 'id_sabor']],
            [['id_presentacion'], 'exist', 'skipOnError' => true, 'targetClass' => CatPresentaciones::className(), 'targetAttribute' => ['id_presentacion' => 'id_presentacion']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => CatProductos::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_entradas' => 'Entrada ID',
            'id_sabor' => 'Sabor ID',
            'id_presentacion' => 'Presentacion ID',
            'id_producto' => 'Producto ID',
            'cantidad_entradas_producto' => 'Cantidad Entrada Producto',
        ];
    }
    /**
     * Gets query for [[Entrada]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntrada()
    {
        return $this->hasOne(Entradas::className(), ['id_entradas' => 'id_entradas']);
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

    /**
     * Gets query for [[Sabor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSabor()
    {
        return $this->hasOne(CatSabores::className(), ['id_sabor' => 'id_sabor']);
    }

    /**
     * Gets query for [[Presentacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPresentacion()
    {
        return $this->hasOne(CatPresentaciones::className(), ['id_presentacion' => 'id_presentacion']);
    }
}
