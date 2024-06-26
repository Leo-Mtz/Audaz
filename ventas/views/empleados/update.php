<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatEmpleados */

$this->title = 'Actualizar Empleado: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Empleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id_empleado]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cat-empleados-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
