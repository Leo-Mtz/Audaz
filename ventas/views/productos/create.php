<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatProductos */

$this->title = 'Agregar Producto';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-productos-create">

    <?= $this->render('_form', [
        'model' => $model,
		'sabores' => $sabores,
        'presentaciones' => $presentaciones,
    ]) ?>

</div>
