<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatSaboresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sabores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-sabores-index">

    <p>
        <?= Html::a('Agregar Sabor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_sabor',
            'sabor',

            [
				'class' => 'yii\grid\ActionColumn',
				'header' => 'Acciones',
				'headerOptions' => ['style' => 'color:#007bff'],
				'contentOptions' => ['style' => 'width:12%;'],
				'template' => '{view}{update}{delete}',
				'buttons' => [
					'view' => function ($url, $model) {
						$url = Url::to(['sabores/view','id'=>$model->id_sabor]);
						return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
					},

					'update' => function ($url, $model) {
						$url = Url::to(['sabores/update','id'=>$model->id_sabor]);
						return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
					},
										
					'delete' => function ($url, $model) {
						$url = Url::to(['sabores/delete','id'=>$model->id_sabor]);
						return Html::a('<span class="fa fa-times"></span>', $url, ['title' => 'Borrar','data-confirm' => Yii::t('yii', '¿Seguro que desea eliminar este sabor?'), 'data-method'  => 'post']);
					}
				],
			],
        ],
    ]); ?>


</div>
