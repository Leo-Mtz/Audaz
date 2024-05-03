<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalidasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salidas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salidas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Salidas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_salidas',
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
            'cantidad_vendida',
            'cantidad_degustacion',
            'cantidad_cortesia',
            'cantidad_total',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
