<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NoLocalizados */

$this->title = 'Descarga No Localizados';
$this->params['breadcrumbs'][] = ['label' => 'No Localizados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="no-localizados-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
