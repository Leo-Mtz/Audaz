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
        'presentacionesList'=> $presentacionesList,
        
    ]) ?>

</div>
