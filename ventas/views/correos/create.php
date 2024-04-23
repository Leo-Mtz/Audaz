<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CorreosAlerta */

$this->title = 'Agregar Correo';
$this->params['breadcrumbs'][] = ['label' => 'Correos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="correos-alerta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
