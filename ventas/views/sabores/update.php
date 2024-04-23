<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatSabores */

$this->title = 'Actualizar Sabor: ' . $model->sabor;
$this->params['breadcrumbs'][] = ['label' => 'Sabores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sabor, 'url' => ['view', 'id' => $model->id_sabor]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cat-sabores-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
