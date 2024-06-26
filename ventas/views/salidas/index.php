<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\CatSabores;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalidasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salidas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salidas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Salida', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $sabores = ArrayHelper::map(CatSabores::find()->all(), 'id_sabor', 'sabor'); ?>
    <?php $eventos = ArrayHelper::map(app\models\CatEventos::find()->all(), 'id_evento', 'evento'); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_salidas',
            'fecha',
            [
                'attribute' => 'id_empleado',
                'value' => function($model, $index, $dataColumn) {
                    return $model->empleados ? $model->empleados->id_empleado : null;
                },
            ],
            
            [
                'attribute' => 'id_evento',
                'value' => function($model) {
                    return $model->sabores ? $model->eventos->evento : null;
                },
                'filter' => Html::activeDropDownList($searchModel, 'id_evento', $eventos, ['class' => 'form-control', 'prompt' => '']),
            ],

            [
                'attribute' => 'id_sabor',
                'value' => function($model) {
                    return $model->sabores ? $model->sabores->sabor : null;
                },
                'filter' => Html::activeDropDownList($searchModel, 'id_sabor', $sabores, ['class' => 'form-control', 'prompt' => '']),
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
                        $url = Url::to(['salidas/view', 'id' => $model->id_salidas]);
                        return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver', 'style' => 'margin-right:10px']);
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['salidas/update', 'id' => $model->id_salidas]);
                        return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar', 'style' => 'margin-right:10px']);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['salidas/delete', 'id' => $model->id_salidas]);
                        return Html::a('<span class="fa fa-times"></span>', $url, [
                            'title' => 'Borrar',
                            'style' => 'margin-right:10px',
                            'data' => [
                                'confirm' => '¿Estás seguro que quieres eliminar esta entrada?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
