<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rfc */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'RFC', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rfc, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="rfc-update">

    <h1><?= Html::encode('Actualizar RFC: ' . $model->rfc) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'items' => $items,
    ]) ?>

</div>
