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

// Set the page title and breadcrumbs for navigation
$this->title = $model->id_venta;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Create a data provider for the related products of the current sale
$dataProvider = new ActiveDataProvider([
    'query' => $model->getProductosPorVenta(), // Gets the related products for this sale
    'pagination' => false, // Disables pagination for this view
]);

?>
<div class="ventas-view">

    <!-- Page title -->
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- Buttons for update, create new sale, and delete actions -->
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

    <!-- DetailView widget to display basic sale information -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_venta',
                'label' => 'Folio', // Custom label for the sale ID
            ],
            'fecha', // Sale date
            'productos_totales', // Total products in the sale
            'tipo_de_venta', // Type of sale
        ],
    ]) ?>

    <h2>Productos</h2>

    <!-- GridView widget to display the products associated with the sale -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id_producto',
                'label' => 'Producto', // Custom label for the product column
                'value' => function ($model) {
                    // Retrieve and display product details
                    $producto = CatProductos::findOne($model->id_producto);
                    return $producto ? $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion : 'N/A';
                },
            ],
            [
                'attribute' => 'cantidad_vendida',
                'label' => 'Cantidad Vendida', // Label for quantity sold
            ],
            [
                'attribute' => 'subtotal_producto',
                'label' => 'Subtotal', // Label for the subtotal
                'value' => function ($model) {
                    return '$' . $model->subtotal_producto; // Format subtotal as currency
                },
            ],
        ],
    ]) ?>

    <!-- Additional details for the sale -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'forma_de_pago', // Payment method
            'cantidad_total_vendida', // Total quantity sold
            [
                'attribute' => 'precio_total_venta',
                'value' => function ($model) {
                    return '$' . $model->precio_total_venta; // Format total price as currency
                },
            ],
        ],
    ]) ?>

    <!-- Group of action buttons for generating a ticket and accepting the sale -->
    <div id="button-group">
        <?= Html::a('Generar Ticket', ['ventas/agregar-ticket', 'id' => $model->id_venta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Aceptar', ['ventas/index', 'id' => $model->id_venta], ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php
// Custom CSS to style the button group
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
