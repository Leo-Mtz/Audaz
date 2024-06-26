<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Exigibles */

$this->title = 'Descarga Exigibles';
$this->params['breadcrumbs'][] = ['label' => 'Exigibles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exigibles-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
