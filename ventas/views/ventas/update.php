<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\CatProductos;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */
/* @var $productosDropdown array */
/* @var $id_evento integer */
/* @var $dataProvider yii\data\ActiveDataProvider */

<<<<<<< HEAD
$this->title = 'Update Ventas: ' . $model->id_venta;
=======
$this->title = 'Actualizar Venta: ' . $model->id_venta;
>>>>>>> main
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_venta, 'url' => ['view', 'id' => $model->id_venta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ventas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'productosDropdown' => $productosDropdown,
        'id_evento' => $id_evento,
    ]) ?>

    <h2>Productos Vendidos</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id_producto',
                'label' => 'Producto (Sabor y Presentación)',
                'value' => function ($model) {
                    $producto = CatProductos::findOne($model->id_producto);
                    return $producto ? $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion : 'N/A';
                },
            ],
            'cantidad_vendida',
            [
                'attribute' => 'subtotal_producto',
                'label' => 'Subtotal',
                'value' => function ($model) {
                    return '$' . $model->subtotal_producto;
                },
            ],
        ],
    ]) ?>

</div>
