<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\Url;

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

                'attribute'=>'id_sabor',
                'value'=>function($model,$index,$dataColumn)
                {
                    return $model->sabores->id_sabor;
                }

            ],


            'cantidad_vendida',
            'cantidad_degustacion',
            'cantidad_cortesia',
            'cantidad_total',
          

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#007bff'],
                'contentOptions' => ['style' => 'width:12%;'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $url = Url::to(['salidas/view','id'=>$model->id_salidas]);
                        return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['salidas/update','id'=>$model->id_salidas]);
                        return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['salidas/delete','id'=>$model->id_salidas]);
                        return Html::a('<span class="fa fa-times"></span>', $url, [
                            'title' => 'Borrar',
                            'style' => 'margin-right:10px',
                            'data' => [
                                'confirm' => '¿Estás seguro que quieres eliminar esta entrada?',
                                'method' => 'post', // Cambiar método a POST
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
     


