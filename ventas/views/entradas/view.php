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
        <?= Html::a('Update', ['update', 'id' => $model->id_entradas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_entradas], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'id_entradas',
            'fecha',
            
            
            [
                'attribute'=>'id_empleado',
                'value'=>$model->empleados->id_empleado,
               
            ],
            [
                'attribute'=>'id_evento',
                'value'=>$model->eventos->id_evento,
                
    
            ],
            [
                'attribute' => 'id_producto',
                'value'=>$model->productos->id_producto,
    
            ],
            
            'cantidad_entradas',
        ],
    ]) ?>

</div>
