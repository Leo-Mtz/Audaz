<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Salidas */

$this->title = 'Actualizacion de Salida: ' . $model->id_salidas;
$this->params['breadcrumbs'][] = ['label' => 'Salidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_salidas, 'url' => ['view', 'id' => $model->id_salidas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="salidas-update">


    <?= $this->render('_form', [
            
            
        'model' => $model,
        'empleados' => $empleados,
         'eventos' => $eventos,
         'sabores'=> $sabores,
         
            
    ]) ?>

</div>
