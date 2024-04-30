<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Entradas */

$this->title = $model->id_entradas;
$this->params['breadcrumbs'][] = ['label' => 'Entradas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="entradas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_entradas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_entradas], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Eliminar la entrada?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id_entradas',
            'fecha',
            
            
            [
                'attribute'=>'id_empleado',
                'value'=>function($model,$index,$dataColumn)
                {
                    return $model->empleados->id_empleado;
                },
            ],
            [
                'attribute'=>'id_evento',
                'value'=>function($model,$index,$dataColumn)
                {
                    return $model->eventos->id_evento;
                }
    
            ],
            [
                'attribute' => 'id_producto',
                'value' =>function($model,$index,$dataColumn)
    
                {
                    return $model->productos->id_producto;
                },
    
            ],
            
            'cantidad_entradas',
        ],
    ]) ?>

</div>
