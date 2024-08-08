<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\CatProductos;
use yii\widgets\DetailView; 
use yii\data\ActiveDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Ventas */

// Set the page title and breadcrumbs for navigation
$this->title = $model->id_entradas;
$this->params['breadcrumbs'][] = ['label' => 'Entrada', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Create a data provider for the related products of the current sale
$dataProvider = new ActiveDataProvider([
    'query' => $model->getProductosPorEntradas(), // Gets the related products for this sale
    'pagination' => false, // Disables pagination for this view
]);

?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <!-- Buttons for update, create new sale, and delete actions -->
    <?= Html::a('Update', ['update', 'id' => $model->id_entradas], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Nueva Venta', ['create', 'id' => $model->id_entradas], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id_entradas], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<div class="entradas-view">


    <div class="row">
        <div class="col-md-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute'=>'id_empleado',
                        'value'=>$model->empleados->id_empleado,
                       
                    ],
                    [
                        'attribute'=>'id_evento',
                        'value'=>$model->eventos->evento,
                        
            
                    ],
            
                    [
                        'attribute' => 'entradas_totales',
                        'label' => 'Número de Entradas',
                    ],

                    'cantidad_entradas',
                ],
            ]) ?>
        </div>
    </div>

    <h2>Detalles de Productos</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id_producto',
                'label' => 'Producto', // Custom label for the product column
                'value' => function ($model) {
                    // Retrieve and display product details
                    $producto = CatProductos::findOne($model->id_producto);
                    return $producto ? $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion : 'N/A';
                },
            ],
            'cantidad_entradas_producto',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}', // Add or remove buttons as needed
            ],
        ],
    ]); ?>

    <div id="button group">
    <?= Html::a('Aceptar', ['entradas/index', 'id' => $model->id_entradas], ['class' => 'btn btn-success']) ?>
  
    </div>

</div>



<?php
// Custom CSS to style the button group
$css = <<<CSS
.button-group {
    margin-top: 20px;
    text-align: center;
}

.button-group .btn {
    margin: 5px;
}
CSS;
$this->registerCss($css);
?>
