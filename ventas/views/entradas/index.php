<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntradasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entradas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entradas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Entradas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //'id_entradas',
        'fecha',
        [
            'attribute'=>'id_empleado',
            'value'=>function($model) {
                return $model->empleados->id_empleado;
            },
        ],
        [
            'attribute'=>'id_evento',
            'value'=>function($model) {
                return $model->eventos->id_evento;
            }
        ],
        [
            'attribute' => 'id_producto',
            'value' => function($model) {
                return $model->productos->id_producto;
            },
        ],
        'cantidad_entradas',

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'headerOptions' => ['style' => 'color:#007bff'],
            'contentOptions' => ['style' => 'width:12%;'],
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    $url = Url::to(['entradas/view','id'=>$model->id_entradas]);
                    return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
                },
                'update' => function ($url, $model) {
                    $url = Url::to(['entradas/update','id'=>$model->id_entradas]);
                    return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
                },
                'delete' => function ($url, $model) {
                    $url = Url::to(['entradas/delete','id'=>$model->id_entradas]);
                    return Html::a('<span class="fa fa-times"></span>', $url, [
                        'title' => 'Borrar',
                        'data-confirm' => Yii::t('yii', '¿Seguro que desea eliminar esta entrada?'),
                        'data-method' => 'post'
                    ]);
                }
            ],
        ],
    ],
]); ?>
 