<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_presentaciones".
 *
 * @property int $id_presentacion
 * @property string $presentacion
 */
class CatPresentaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_presentaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['presentacion'], 'required'],
            [['presentacion'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_presentacion' => 'Id Presentacion',
            'presentacion' => 'Presentacion',
        ];
    }

    public static function getPresentacionesBySabor($idSabor)
{
    return self::find()
        ->joinWith('CatProductos')
        ->where(['cat_productos.id_sabor' => $idSabor])
        ->select(['presentacion', 'id_presentacion'])
        ->indexBy('id_presentacion')
        ->column();
}
}
