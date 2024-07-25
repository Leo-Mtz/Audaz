
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;
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

    <?php $eventos = ArrayHelper::map(app\models\CatEventos::find()->all(), 'id_evento', 'evento'); ?>

    <?php  $formasDePago = [
        'efectivo' => 'Efectivo',
        'tarjeta' => 'Tarjeta de Crédito/Débito',
        'transferencia' => 'Transferencia Bancaria',
    ];

    $tipo_de_venta= [
        'venta' => 'Venta',
        'degustacion' => 'Degustación',
        'cortesia' => 'Cortesía',
    ]; 
    ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
   

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
    
            'id_venta',
            [
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->fecha);
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'fecha',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class' => 'form-control',
                    ],
                ]),
            ],
            
            
        [
            'attribute' => 'id_evento',
            'value' => function($model) {
                return  $model->eventos ? $model->eventos->evento : null;
            },
            'filter' => Html::activeDropDownList($searchModel, 'id_evento', $eventos, ['class' => 'form-control', 'prompt' => '']),
        ],
        
            'id_vendedor',
            'productos_totales',

            [ 'attribute' => 'tipo_de_venta',
                'value' => function($model) {
                    return $model->tipo_de_venta;
                },
                'filter' => Html::activeDropDownList($searchModel, 'tipo_de_venta', $tipo_de_venta, ['class' => 'form-control', 'prompt' => '']),

            ],

            [
                'attribute' => 'forma_de_pago',
                'value' => function($model) {
                    return $model->forma_de_pago;
                },
                'filter' => Html::activeDropDownList($searchModel, 'forma_de_pago', $formasDePago, ['class' => 'form-control', 'prompt' => '']),
            ],
            
            [
               'attribute' => 'precio_total_venta',
            'value' => function ($model) {
                return '$' . $model->precio_total_venta;
            }, 
        ],
    
        

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'headerOptions' => ['style' => 'color:#007bff'],
            'contentOptions' => ['style' => 'width:12%;'],
            'template' => '{view} {update} {delete} {ticket}',
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
                'ticket' => function ($url, $model) {
                        $url = Url::to(['ventas/ticket', 'id' => $model->id_venta]);
                        return Html::a('<span class="fa-solid fa-ticket"></span>', $url, ['title' => 'Ticket', 'style' => 'margin-right:10px']);
                    },
            ],
        ],
    ],
    ]); ?>
 