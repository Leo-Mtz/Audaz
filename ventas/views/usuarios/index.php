<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <p>
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'username',
            // 'password',
            // 'authKey',

            [
				'class' => 'yii\grid\ActionColumn',
				'header' => 'Acciones',
				'headerOptions' => ['style' => 'color:#007bff'],
				'contentOptions' => ['style' => 'width:12%;'],
				'template' => '{view}{update}{reset}{delete}',
				'buttons' => [
					'view' => function ($url, $model) {
						$url = Url::to(['usuarios/view','id'=>$model->id]);
						return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
					},

					'update' => function ($url, $model) {
						$url = Url::to(['usuarios/update','id'=>$model->id]);
						return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
					},
					
					'reset' => function ($url, $model) {
						$url = Url::to(['usuarios/pass','id'=>$model->id]);
						return Html::a('<span class="fa fa-retweet"></span>', $url, ['title' => 'Reiniciar Contraseña','style' => 'margin-right:10px','data-confirm' => Yii::t('yii', '¿Desea reiniciar la contraseña para este usuario?'), 'data-method'  => 'post']);
					},
					
					'delete' => function ($url, $model) {
						$url = Url::to(['usuarios/delete','id'=>$model->id]);
						return Html::a('<span class="fa fa-times"></span>', $url, ['title' => 'Borrar','data-confirm' => Yii::t('yii', '¿Seguro que desea eliminar este registro?'), 'data-method'  => 'post']);
					}
				],
				// 'visibleButtons' => [
					// 'delete' => function($model, $key, $index){
						// return $model->borrado === "0";
					// }
				// ]
			],
        ],
    ]); ?>


</div>
