<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "entradas".
 *
 * @property int $id_entradas
 * @property string $fecha
 * @property int $id_empleado
 * @property int $id_evento
 * @property int $id_sabor
 * @property int $id_presentacion
 * @property float|null $cantidad_entradas
 * @property int $id_prueba
 * @property int $id_375ml
 * @property int $id_750ml
 * @property int $id_16onz
 * @property int $id_2L
 *  @property int $id_prueba
 * @property float|null $cantidad_375ml
 * @property float|null $cantidad_750ml
 * @property float|null $cantidad_16onz
 * @property float|null $cantidad_2L    
 * @property float|null $cantidad_pruebas
 *  @property float|null $cantidad_entradas
 */
class Entradas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entradas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'id_empleado', 'id_evento', 'id_sabor', 'id_prueba', 'cantidad_pruebas', 'id_375ml', 'id_750ml', 'id_16onz', 'id_2L','cantidad_entradas', 'cantidad_375ml', 'cantidad_750ml', 'cantidad_16onz', 'cantidad_2L'], 'required'],
            [['id_empleado', 'id_evento', 'id_sabor', 'id_prueba'], 'integer'],
            [['fecha'], 'safe'],
            [['cantidad_pruebas', 'cantidad_entradas', 'cantidad_375ml', 'cantidad_750ml', 'cantidad_16onz', 'cantidad_2L'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_entradas' => 'Entrada',
            'fecha' => 'Fecha',
            'id_empleado' => 'Id Empleado',
            'id_evento' => 'Evento',
            'id_sabor' => 'Sabor',
            'id_prueba' => 'Prueba',
            'cantidad_pruebas' => 'Cantidad Pruebas',

            
            'id_375ml' => '375ml',
            'cantidad_375ml' => 'Cantidad 375ml',
            
            'id_750ml' => '750ml',
            'cantidad_750ml' => 'Cantidad 750ml',
            'id_16onz' => '16onz',
            'cantidad_16onz' => 'Cantidad 16onz',
            'id_2L' => '2L',
            'cantidad_2L' => 'Cantidad 2L',

            'cantidad_entradas' => 'Cantidad Entradas',
        ];
    }

    public function getEventos()
    {
        return $this->hasOne(CatEventos::className(), ['id_evento' => 'id_evento']);
    }

    public function getEmpleados()
    {
        return $this->hasOne(CatEmpleados::className(), ['id_empleado' => 'id_empleado']);
    }

    public function getSabores()
    {
        return $this->hasOne(CatSabores::className(), ['id_sabor' => 'id_sabor']);
    }

   

    public function getIdPrueba()
    {
        return $this->hasOne(CatPresentaciones::find()->all(), 'presentacion', 'presentacion')
        ->select('id_presentacion')
        ->andWhere(['presentacion' => 'PRUEBA'])
        ->scalar();
    }


    

    public function getId375ml()
{
    
    return $this->hasOne(CatPresentaciones::find()->all(), 'presentacion', 'presentacion')
        ->select('id_presentacion')
        ->andWhere(['presentacion' => '375 ml'])
        ->scalar();
}

public function getId750ml()
{
    
    return $this->hasOne(CatPresentaciones::find()->all(), 'presentacion', 'presentacion')
    >select('id_presentacion')
    ->andWhere(['presentacion' => '750 ml'])
    ->scalar();
}

public function getId16onz()
{
    
    return $this->hasOne(CatPresentaciones::find()->all(), 'presentacion', 'presentacion')
    >select('id_presentacion')
    ->andWhere(['presentacion' => '16 onz'])
    ->scalar();
}

public function getId2L()
{
    
    return $this->hasOne(CatPresentaciones::find()->all(), 'presentacion', 'presentacion')
    
         >select('id_presentacion')
        ->andWhere(['presentacion' => '2L'])
        ->scalar();
}
}

