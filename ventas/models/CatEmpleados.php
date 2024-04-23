<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_empleados".
 *
 * @property int $id_empleado
 * @property string $nombre
 * @property string|null $paterno
 * @property string|null $materno
 * @property string|null $fecha_inicio
 */
class CatEmpleados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_empleados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['fecha_inicio'], 'safe'],
            [['nombre', 'paterno', 'materno'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_empleado' => 'Id Empleado',
            'nombre' => 'Nombre',
            'paterno' => 'Paterno',
            'materno' => 'Materno',
            'fecha_inicio' => 'Fecha Inicio',
        ];
    }
}
