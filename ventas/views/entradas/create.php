<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Entradas */

$this->title = 'Registro de Entrada';
$this->params['breadcrumbs'][] = ['label' => 'Entradas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entradas-create">


    <?= $this->render('_form', [
        
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
