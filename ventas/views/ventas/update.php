<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */
/* @var $productosDropdown array */
/* @var $id_evento integer */
/* @var $productosPorVenta array */

$this->title = 'Actualizar Venta: ' . $model->id_venta;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_venta, 'url' => ['view', 'id' => $model->id_venta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ventas-update">

    <?= $this->render('_form', [
        'model' => $model,
            'productosPorVenta' => $productosPorVenta,
            'productosDropdown' => $productosDropdown,
            'id_evento' => $id_evento,
    ]) ?>

</div>
