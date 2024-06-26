<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CatPresentaciones */

$this->title = $model->presentacion;
$this->params['breadcrumbs'][] = ['label' => 'Presentaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cat-presentaciones-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_presentacion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_presentacion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Eliminar esta presentación?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_presentacion',
            'presentacion',
        ],
    ]) ?>

</div>
