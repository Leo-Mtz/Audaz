<?php
namespace app\models;


use app\models\CatProductos;
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
            [['fecha', 'id_empleado', 'id_evento', 'id_sabor','cantidad_entradas', 'entradas_totales'], 'required'],
            [['id_empleado','id_presentacion', 'id_evento', 'id_sabor', 'entradas_totales'], 'integer'],
            [['fecha'], 'safe'],
            [[ 'cantidad_entradas'], 'number'],
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
            'id_presentacion'=> 'Presentacion',
            'cantidad_entradas' => 'Cantidad Entradas',
            'entradas_totales' => 'Entradas Totales',
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

    

   

public function afterSave($insert, $changedAttributes)
{
    parent::afterSave($insert, $changedAttributes);

    if ($insert) {
        // Update the stock after creating a new Entrada
        $producto = CatProductos::findOne($this->id_producto);

        if ($producto !== null) {
            $producto->updateInventoryQuantity();
        }
    }
}

}

