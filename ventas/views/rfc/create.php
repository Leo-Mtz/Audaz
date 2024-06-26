<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rfc */

$this->title = 'Agregar RFC';
$this->params['breadcrumbs'][] = ['label' => 'RFC', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rfc-create">
    <?= $this->render('_form', [
        'model' => $model,'items' => $items,
    ]) ?>

</div>
