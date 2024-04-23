<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NoLocalizados */

$this->title = 'Update No Localizados: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'No Localizados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="no-localizados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
