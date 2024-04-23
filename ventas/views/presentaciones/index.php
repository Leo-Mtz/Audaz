<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatPresentacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presentaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-presentaciones-index">

    <p>
        <?= Html::a('Agregar Presentación', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_presentacion',
            'presentacion',

            [
				'class' => 'yii\grid\ActionColumn',
				'header' => 'Acciones',
				'headerOptions' => ['style' => 'color:#007bff'],
				'contentOptions' => ['style' => 'width:12%;'],
				'template' => '{view}{update}{delete}',
				'buttons' => [
					'view' => function ($url, $model) {
						$url = Url::to(['presentaciones/view','id'=>$model->id_presentacion]);
						return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
					},

					'update' => function ($url, $model) {
						$url = Url::to(['presentaciones/update','id'=>$model->id_presentacion]);
						return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
					},
										
					'delete' => function ($url, $model) {
						$url = Url::to(['presentaciones/delete','id'=>$model->id_presentacion]);
						return Html::a('<span class="fa fa-times"></span>', $url, ['title' => 'Borrar','data-confirm' => Yii::t('yii', '¿Seguro que desea eliminar esta presentación?'), 'data-method'  => 'post']);
					}
				],
			],
        ],
    ]); ?>


</div>
