<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Firmes */

$this->title = 'Descarga Firmes';
$this->params['breadcrumbs'][] = ['label' => 'Firmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firmes-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
