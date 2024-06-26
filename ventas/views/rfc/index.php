<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RfcSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'RFC';
$this->params['breadcrumbs'][] = "RFC";
?>
<div class="rfc-index">

    <p>
        <?= Html::a('Agregar RFC', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'rfc',
            'razon_social',
            [
                'attribute'=>'patente',
				'value'=>'patentes.patente',
            ],
            'agente_aduanal',
            'descripcion:html',
            [
                'attribute'=>'borrado',
				'value'=>function($data){
					return $data->borrado == "1" ? "BORRADO" : "ACTIVO";
				},
				'filter' => ['0' => 'ACTIVO', '1' => 'BORRADO'],
            ],
            [
				'class' => 'yii\grid\ActionColumn',
				'header' => 'Acciones',
				'headerOptions' => ['style' => 'color:#007bff'],
				'contentOptions' => ['style' => 'width:8.5%;'],
				'template' => '{view}{update}{delete}',
				'buttons' => [
					'view' => function ($url, $model) {
						$url = Url::to(['rfc/view','id'=>$model->id]);
						return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
					},

					'update' => function ($url, $model) {
						$url = Url::to(['rfc/update','id'=>$model->id]);
						return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
					},
					
					'delete' => function ($url, $model) {
						$url = Url::to(['rfc/delete','id'=>$model->id]);
						return Html::a('<span class="fa fa-times"></span>', $url, ['title' => 'Borrar','data-confirm' => Yii::t('yii', '¿Seguro que desea eliminar este registro?'), 'data-method'  => 'post']);
					}
				],
				'visibleButtons' => [
					'delete' => function($model, $key, $index){
						return $model->borrado === "0";
					}
				]
			],
        ],
    ]); ?>


</div>
