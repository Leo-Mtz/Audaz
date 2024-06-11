<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Salidas */

$this->title = 'Create Salidas';
$this->params['breadcrumbs'][] = ['label' => 'Salidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salidas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        
        'model' => $model,
        'empleados' => $empleados,
         'eventos' => $eventos,
         'sabores'=> $sabores,
         'presentaciones'=> $presentaciones,
    ]) ?>

</div>
