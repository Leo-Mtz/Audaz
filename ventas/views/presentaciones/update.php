<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatPresentaciones */

$this->title = 'Actualizar Presentación: ' . $model->presentacion;
$this->params['breadcrumbs'][] = ['label' => 'Presentaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->presentacion, 'url' => ['view', 'id' => $model->id_presentacion]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cat-presentaciones-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
