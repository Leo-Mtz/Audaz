<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */

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


    <?= $this->render('_form', [
 
 
        'model'=>$model,
        'productosDropdown'=>$productosDropdown,
                   ]) ?>

</div>
