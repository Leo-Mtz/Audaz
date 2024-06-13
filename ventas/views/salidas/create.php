<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Salidas */

$this->title = 'Registro de Salida';
$this->params['breadcrumbs'][] = ['label' => 'Salidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salidas-create">


    <?= $this->render('_form', [
        
    
            'model' => $model, 
           'empleados' => $empleados,
           'eventos' => $eventos,
           'sabores'=> $sabores,
           
           
        
    ]) ?>

</div>
