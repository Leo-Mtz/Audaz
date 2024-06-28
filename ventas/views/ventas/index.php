
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\CatProductos;


/* @var $this yii\web\View */
/* @var $searchModel app\models\EntradasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de ventas';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="entradas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Registro de Venta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
   

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
    
        
            'id_venta',
            'fecha',
            

            [
                'attribute' => 'id_producto',
<<<<<<< HEAD
                'label' => 'Producto',
=======
>>>>>>> main
                'value' => function ($model) {
                    $productos = CatProductos::find()->all();
                    $productosDropdown = [];
                    foreach ($productos as $producto) {
                        $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
                    }
                    return $productosDropdown[$model->id_producto];
                },
            ],

            'cantidad_vendida',
            'id_vendedor',
            'id_evento',
            'precio_total_producto',
            'precio_unitario',
            'precio_total_venta',

    
        

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'headerOptions' => ['style' => 'color:#007bff'],
            'contentOptions' => ['style' => 'width:12%;'],
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    $url = Url::to(['ventas/view','id'=>$model->id_venta]);
                    return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
                },
                'update' => function ($url, $model) {
                    $url = Url::to(['ventas/update','id'=>$model->id_venta]);
                    return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
                },
                'delete' => function ($url, $model) {
                    $url = Url::to(['ventas/delete','id'=>$model->id_venta]);
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
 
