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
}
