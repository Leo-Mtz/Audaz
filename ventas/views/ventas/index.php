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

// Set the page title and breadcrumbs
$this->title = 'Listado de ventas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="entradas-index">

    <!-- Page title -->
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Button to create a new sale -->
    <p>
        <?= Html::a('Registro de Venta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <!-- Dropdown lists for filtering -->
    <?php 
    // Dropdown list for events
    $eventos = ArrayHelper::map(app\models\CatEventos::find()->all(), 'id_evento', 'evento'); 

    // Dropdown list for payment methods
    $formasDePago = [
        'efectivo' => 'Efectivo',
        'tarjeta' => 'Tarjeta de Crédito/Débito',
        'transferencia' => 'Transferencia Bancaria',
    ];

    // Dropdown list for sale types
    $tipo_de_venta = [
        'venta' => 'Venta',
        'degustacion' => 'Degustación',
        'cortesia' => 'Cortesía',
    ]; 
    ?>

    <?php // Optionally include the search form if needed
    // echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <!-- GridView widget to display the list of sales -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Serial column for row numbers

            'id_venta', // Sale ID

            // Date column with a DatePicker filter
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
            
            // Event column with a dropdown filter
            [
                'attribute' => 'id_evento',
                'value' => function($model) {
                    return $model->eventos ? $model->eventos->evento : null;
                },
                'filter' => Html::activeDropDownList($searchModel, 'id_evento', $eventos, ['class' => 'form-control', 'prompt' => '']),
            ],
            
            'id_vendedor', // Vendor ID
            'productos_totales', // Total products in the sale

            // Sale type column with a dropdown filter
            [
                'attribute' => 'tipo_de_venta',
                'value' => function($model) {
                    return $model->tipo_de_venta;
                },
                'filter' => Html::activeDropDownList($searchModel, 'tipo_de_venta', $tipo_de_venta, ['class' => 'form-control', 'prompt' => '']),
            ],

            // Payment method column with a dropdown filter
            [
                'attribute' => 'forma_de_pago',
                'value' => function($model) {
                    return $model->forma_de_pago;
                },
                'filter' => Html::activeDropDownList($searchModel, 'forma_de_pago', $formasDePago, ['class' => 'form-control', 'prompt' => '']),
            ],
            
            // Total price column with currency formatting
            [
                'attribute' => 'precio_total_venta',
                'value' => function ($model) {
                    return '$' . $model->precio_total_venta;
                }, 
            ],

            // Action column with custom buttons
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#007bff'],
                'contentOptions' => ['style' => 'width:12%;'],
                'template' => '{view} {update} {delete} {ticket}', // Buttons to display
                'buttons' => [
                    // View button
                    'view' => function ($url, $model) {
                        $url = Url::to(['ventas/view','id'=>$model->id_venta]);
                        return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver','style' => 'margin-right:10px']);
                    },
                    // Update button
                    'update' => function ($url, $model) {
                        $url = Url::to(['ventas/update','id'=>$model->id_venta]);
                        return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar','style' => 'margin-right:10px']);
                    },
                    // Delete button
                    'delete' => function ($url, $model) {
                        $url = Url::to(['ventas/delete','id'=>$model->id_venta]);
                        return Html::a('<span class="fa fa-times"></span>', $url, [
                            'title' => 'Borrar',
                            'style' => 'margin-right:10px',
                            'data' => [
                                'confirm' => '¿Estás seguro que quieres eliminar esta entrada?',
                                'method' => 'post', // Change method to POST
                            ],
                        ]);
                    },
                    // Ticket button
                    'ticket' => function ($url, $model) {
                        $url = Url::to(['ventas/ticket', 'id' => $model->id_venta]);
                        return Html::a('<span class="fa-solid fa-ticket"></span>', $url, ['title' => 'Ticket', 'style' => 'margin-right:10px']);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
