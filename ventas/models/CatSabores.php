<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_sabores".
 *
 * @property int $id_sabor
 * @property string $sabor
 */
class CatSabores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_sabores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sabor'], 'required'],
            [['sabor'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_sabor' => 'Id Sabor',
            'sabor' => 'Sabor',
        ];
    }

    public static function getSaboresDisponibles()
    {
        return self::find()
            ->select(['s.id_sabor', 's.sabor'])
            ->joinWith('catProductos') // Suponiendo que tienes una relación en el modelo
            ->where(['cat_productos.id_producto' => \yii\db\Query::find()->select('id_producto')])
            ->indexBy('id_sabor')
            ->column();
    }
}
