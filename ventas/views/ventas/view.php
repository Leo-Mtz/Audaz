<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\CatProductos;
use app\models\CatSabores;
use app\models\CatPresentaciones;
use app\models\ProductosPorVenta;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */

$this->title = $model->id_venta;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Fetch the related products for the current sale
$dataProvider = new ActiveDataProvider([
    'query' => $model->getProductosPorVenta(),
    'pagination' => false,
]);

?>
<div class="ventas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_venta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Nueva Venta', ['create', 'id' => $model->id_venta], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'id_venta',
                'label' => 'Folio',
            ],
            'fecha',
            'productos_totales',
            'tipo_de_venta',
        ],
    ]) ?>

    <h2>Productos</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id_producto',
                'label' => 'Producto ',
                'value' => function ($model) {
                    $producto = CatProductos::findOne($model->id_producto);
                    return $producto ? $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion : 'N/A';
                },
            ],
            [
                'attribute' => 'cantidad_vendida',
                'label' => 'Cantidad Vendida',
            ],
            [
                'attribute' => 'subtotal_producto',
                'label' => 'Subtotal',
                'value' => function ($model) {
                    return '$' . $model->subtotal_producto;
                },
            ],
        ],
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'forma_de_pago',
            'cantidad_total_vendida',
            [
                'attribute' => 'precio_total_venta',
                'value' => function ($model) {
                    return '$' . $model->precio_total_venta;
                },
            ],
        ],
    ]) ?>

    

        <div id= button-group>
    <?= Html::a('Generar Ticket', ['ventas/agregar-ticket', 'id' => $model->id_venta], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Aceptar', ['ventas/index', 'id' => $model->id_venta], ['class' => 'btn btn-success']) ?>

    </div>
</div>


<?php
$css = <<<CSS

.button-group {
    margin-top: 20px;
    text-align: center;
}

.button-group .btn {
    margin: 5px;
}


CSS;
$this->registerCss($css);
?>
