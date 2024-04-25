<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Salidas */

$this->title = 'Update Salidas: ' . $model->id_salidas;
$this->params['breadcrumbs'][] = ['label' => 'Salidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_salidas, 'url' => ['view', 'id' => $model->id_salidas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="salidas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
