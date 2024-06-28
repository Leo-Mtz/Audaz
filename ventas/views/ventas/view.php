 <?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CatProductos;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */

$this->title = $model->id_venta;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ventas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_venta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Nueva Venta', ['create', 'id'=>$model->id_venta], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_venta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_venta',
            'fecha',
            
            [
                'attribute' => 'id_producto',
<<<<<<< HEAD
                'label'=>'Producto',
=======
>>>>>>> main
                'value' => function ($model) {
                    $productos = CatProductos::find()->all();
                    $productosDropdown = [];
                    foreach ($productos as $producto) {
                        $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
                    }
                    return $productosDropdown[$model->id_producto];
                },
            ],
            'cantidad_vendida',
<<<<<<< HEAD

            'precio_total_producto',
=======
>>>>>>> main
            'precio_total_venta',
            'id_evento',
            'id_vendedor',
        ],
    ]) ?>

</div>
