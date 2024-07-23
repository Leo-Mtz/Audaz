<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\CatProductos;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */

$this->title = 'Ticket - Venta ' . $model->id_venta;
\yii\web\YiiAsset::register($this);

// Fetch the related products for the current sale
$dataProvider = new ActiveDataProvider([
    'query' => $model->getProductosPorVenta(),
    'pagination' => false,
]);

?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="ticket-details">
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
                    'label' => 'Producto (Sabor y Presentación)',
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

        
    <p>
        <?= Html::a('Imprimir Ticket', '#', ['class' => 'btn btn-primary', 'onclick' => 'window.print(); return false;']) ?>
        
        <?= Html::a('Regresar', 'javascript:history.back()', ['class' => 'btn btn-danger']) ?>
      
        <?= Html::a('Nueva Venta', ['create', 'id' => $model->id_venta], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Aceptar', ['ventas/index', 'id' => $model->id_venta], ['class' => 'btn btn-success']) ?>

    </p>
    </div>

</div>

<?php
$css = <<<CSS
.ticket-view {
    width: 80mm;
    margin: 0 auto;
    padding: 10px;
    font-family: Arial, sans-serif;
}

.ticket-view h1 {
    text-align: center;
    font-size: 16px;
    margin-bottom: 10px;
}

.ticket-view .ticket-details {
    font-size: 12px;
}

.ticket-view .ticket-details h2 {
    font-size: 14px;
    margin-top: 10px;
}

.ticket-view .ticket-details table {
    width: 100%;
    border-collapse: collapse;
}

.ticket-view .ticket-details table, .ticket-view .ticket-details th, .ticket-view .ticket-details td {
    border: 1px solid black;
    padding: 5px;
    text-align: left;
}

.ticket-view .ticket-details th {
    background-color: #f2f2f2;
}

@media print {
    .btn {
        display: none;
    }
}
CSS;
$this->registerCss($css);
?>
