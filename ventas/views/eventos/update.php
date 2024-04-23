<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatEventos */

$this->title = 'Actualizar Evento: ' . $model->evento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->evento, 'url' => ['view', 'id' => $model->id_evento]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cat-eventos-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
