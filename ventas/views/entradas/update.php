<?php

use yii\helpers\Html;
  
/* @var $this yii\web\View */
/* @var $model app\models\Entradas */

$this->title = 'Update Entradas: ' . $model->id_entradas;
$this->params['breadcrumbs'][] = ['label' => 'Entradas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_entradas, 'url' => ['view', 'id' => $model->id_entradas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entradas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        
        
        'model' => $model,
        'empleados' => $empleados,
        'eventos' => $eventos,
        'productosDropdown'=>$productosDropdown,
    ]) ?>

</div>
