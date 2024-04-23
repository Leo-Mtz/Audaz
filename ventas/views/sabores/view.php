<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CatSabores */

$this->title = $model->sabor;
$this->params['breadcrumbs'][] = ['label' => 'Sabores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cat-sabores-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_sabor], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_sabor], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Eliminar este sabor?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_sabor',
            'sabor',
        ],
    ]) ?>

</div>
