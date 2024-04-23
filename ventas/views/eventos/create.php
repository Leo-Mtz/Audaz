<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatEventos */

$this->title = 'Agregar Evento';
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-eventos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
