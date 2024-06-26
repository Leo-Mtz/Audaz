<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CorreosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Correos Alertas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="correos-alerta-index">

    <p>
        <?= Html::a('Agregar Correo', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'correo',
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
				'contentOptions' => ['style' => 'width:9%;'],
				'template' => '{view}{update}{delete}{activate}',
				'buttons' => [
					'view' => function ($url, $model) {
						$url = Url::to(['correos/view','id'=>$model->id]);
						return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
					},

					'update' => function ($url, $model) {
						$url = Url::to(['correos/update','id'=>$model->id]);
						return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
					},
					
					'delete' => function ($url, $model) {
						$url = Url::to(['correos/delete','id'=>$model->id]);
						return Html::a('<span class="fa fa-times"></span>', $url, ['title' => 'Borrar','data-confirm' => Yii::t('yii', '¿Seguro que desea eliminar este registro?'), 'data-method'  => 'post']);
					},
					'activate' => function ($url, $model) {
						$url = Url::to(['correos/activate','id'=>$model->id]);
						return Html::a('<span class="fa fa-check"></span>', $url, ['title' => 'Reactivar Correo','data-confirm' => Yii::t('yii', '¿Seguro que desea reactivar este correo?'), 'data-method'  => 'post']);
					}
				],
				'visibleButtons' => [
					'delete' => function($model, $key, $index){
						return $model->borrado === "0";
					},
					'activate' => function($model, $key, $index){
						return $model->borrado === "1";
					}
				]
			],
        ],
    ]); ?>


</div>
