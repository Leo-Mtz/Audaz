<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatSabores */

$this->title = 'Agregar Sabor';
$this->params['breadcrumbs'][] = ['label' => 'Sabores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-sabores-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
