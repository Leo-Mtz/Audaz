<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatEmpleados */

$this->title = 'Agregar Empleado';
$this->params['breadcrumbs'][] = ['label' => 'Empleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-empleados-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
