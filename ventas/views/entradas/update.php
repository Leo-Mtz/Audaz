<?php

use yii\helpers\Html;
  
/* @var $this yii\web\View */
/* @var $model app\models\Entradas */

$this->title = 'Actualizacion de Entrada: ' . $model->id_entradas;
$this->params['breadcrumbs'][] = ['label' => 'Entradas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_entradas, 'url' => ['view', 'id' => $model->id_entradas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entradas-update">



    <?= $this->render('_form', [
        //variables 
     
        'model' => $model,
       'empleados' => $empleados,
        'eventos' => $eventos,
        'sabores'=> $sabores,
        'presentaciones'=> $presentaciones,
        'prueba' => $prueba,
        'ml375'=> $ml375,
        'ml750'=> $ml750,
        'onz16'=> $onz16,
        'DosLitros'=> $DosLitros,
    ]) ?>

</div>
