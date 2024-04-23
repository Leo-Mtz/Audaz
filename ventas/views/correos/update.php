<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CorreosAlerta */

$this->title = 'Actualizar Correo: ' . $model->correo;
$this->params['breadcrumbs'][] = ['label' => 'Correos Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->correo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="correos-alerta-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
