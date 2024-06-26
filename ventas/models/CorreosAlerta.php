<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "correos_alerta".
 *
 * @property int $id
 * @property string|null $correo
 * @property string|null $borrado
 */
class CorreosAlerta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'correos_alerta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['correo'], 'string', 'max' => 100],
            [['borrado'], 'string', 'max' => 1],
            [['correo'], 'required'],
            [['correo'], 'unique','message' => 'El correo ya esta registrado'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'correo' => 'Correo',
            'borrado' => 'Estatus',
        ];
    }
}
