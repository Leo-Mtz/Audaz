<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatProductos */

$this->title = 'Actualizar Producto: ' . $model->id_producto;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_producto, 'url' => ['view', 'id' => $model->id_producto]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cat-productos-update">

    <?= $this->render('_form', [
        'model' => $model,
		'sabores' => $sabores,
        'presentaciones' => $presentaciones,
    ]) ?>

</div>
