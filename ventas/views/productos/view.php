<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CatProductos */

$this->title = $model->id_producto;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cat-productos-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_producto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_producto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Eliminar el producto?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_producto',
			[
				'attribute'=>'id_sabor',
				'value'=>$model->sabores->sabor,
			],
            [
				'attribute'=>'id_presentacion',
				'value'=>$model->presentaciones->presentacion,
			],
            'precio',
        ],
    ]) ?>

</div>
