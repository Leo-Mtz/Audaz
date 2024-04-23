<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatPresentaciones */

$this->title = 'Agregar Presentación';
$this->params['breadcrumbs'][] = ['label' => 'Presentaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-presentaciones-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
