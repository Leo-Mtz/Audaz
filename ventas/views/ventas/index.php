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

    <div class="d-flex align-items-center">
                <!-- Column Toggle Dropdown -->
                <div class="btn-group mr-2">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Columnas
                    </button>
                    <div class="dropdown-menu">
                        <label><input type="checkbox" class="toggle-column" data-column="column-id-venta" checked> ID Venta</label>
                        <label><input type="checkbox" class="toggle-column" data-column="column-fecha" checked> Fecha</label>
                        <label><input type="checkbox" class="toggle-column" data-column="column-id-evento" checked> Evento</label>
                        <label><input type="checkbox" class="toggle-column" data-column="column-id-vendedor" checked> Vendedor</label>
                        <label><input type="checkbox" class="toggle-column" data-column="column-productos-totales" checked> Productos Totales</label>
                        <label><input type="checkbox" class="toggle-column" data-column="column-tipo-de-venta" checked> Tipo de Venta</label>
                        <label><input type="checkbox" class="toggle-column" data-column="column-forma-de-pago" checked> Forma de Pago</label>
                        <label><input type="checkbox" class="toggle-column" data-column="column-precio-total-venta" checked> Precio Total Venta</label>
                    </div>
                </div>

             <!-- Restore Defaults Button -->
                <button id="restore-defaults" class="btn btn-secondary">Restaurar Columnas</button>
            </div>
        </div>
        
    <?php $eventos = ArrayHelper::map(app\models\CatEventos::find()->all(), 'id_evento', 'evento'); ?>
    <?php $formasDePago = [
        'efectivo' => 'Efectivo',
        'tarjeta' => 'Tarjeta de Crédito/Débito',
        'transferencia' => 'Transferencia Bancaria',
    ]; ?>
    <?php $tipo_de_venta = [
        'venta' => 'Venta',
        'degustacion' => 'Degustación',
        'cortesia' => 'Cortesía',
    ]; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="container-fluid">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id_venta',
                'headerOptions' => ['class' => 'column-id-venta'],
                'contentOptions' => ['class' => 'column-id-venta'],
            ],
            [
                'attribute' => 'fecha',
                'headerOptions' => ['class' => 'column-fecha'],
                'contentOptions' => ['class' => 'column-fecha'],
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
                'headerOptions' => ['class' => 'column-id-evento'],
                'contentOptions' => ['class' => 'column-id-evento'],
                'value' => function($model) {
                    return  $model->eventos ? $model->eventos->evento : null;
                },
                'filter' => Html::activeDropDownList($searchModel, 'id_evento', $eventos, ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'id_vendedor',
                'headerOptions' => ['class' => 'column-id-vendedor'],
                'contentOptions' => ['class' => 'column-id-vendedor'],
            ],
            [
                'attribute' => 'productos_totales',
                'headerOptions' => ['class' => 'column-productos-totales'],
                'contentOptions' => ['class' => 'column-productos-totales'],
            ],
            [
                'attribute' => 'tipo_de_venta',
                'headerOptions' => ['class' => 'column-tipo-de-venta'],
                'contentOptions' => ['class' => 'column-tipo-de-venta'],
                'value' => function($model) {
                    return $model->tipo_de_venta;
                },
                'filter' => Html::activeDropDownList($searchModel, 'tipo_de_venta', $tipo_de_venta, ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'forma_de_pago',
                'headerOptions' => ['class' => 'column-forma-de-pago'],
                'contentOptions' => ['class' => 'column-forma-de-pago'],
                'value' => function($model) {
                    return $model->forma_de_pago;
                },
                'filter' => Html::activeDropDownList($searchModel, 'forma_de_pago', $formasDePago, ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'precio_total_venta',
                'headerOptions' => ['class' => 'column-precio-total-venta'],
                'contentOptions' => ['class' => 'column-precio-total-venta'],
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
                        $url = Url::to(['ventas/view', 'id' => $model->id_venta]);
                        return Html::a('<span class="fa fa-search"></span>', $url, ['title' => 'Ver', 'style' => 'margin-right:10px']);
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['ventas/update', 'id' => $model->id_venta]);
                        return Html::a('<span class="fa fa-edit"></span>', $url, ['title' => 'Actualizar', 'style' => 'margin-right:10px']);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['ventas/delete', 'id' => $model->id_venta]);
                        return Html::a('<span class="fa fa-times"></span>', $url, [
                            'title' => 'Borrar',
                            'style' => 'margin-right:10px',
                            'data' => [
                                'confirm' => '¿Estás seguro que quieres eliminar esta entrada?',
                                'method' => 'post',
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
</div>

<style>
    /* Hide column classes by default */
.column-id-venta,
.column-fecha,
.column-id-evento,
.column-id-vendedor,
.column-productos-totales,
.column-tipo-de-venta,
.column-forma-de-pago,
.column-precio-total-venta {
    display: table-cell;
}

/* Hide columns with .hidden class */
.hidden {
    display: none !important;
}

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    
    const checkboxes = document.querySelectorAll('.toggle-column');
    console.log('Checkboxes:', checkboxes);

    // Load saved state from localStorage
    checkboxes.forEach(checkbox => {
        const columnClass = checkbox.getAttribute('data-column');
        checkbox.checked = localStorage.getItem('column_' + columnClass) === 'true';
        console.log(`Checkbox ${columnClass} checked: ${checkbox.checked}`);
        toggleColumnVisibility(checkbox); // Ensure columns are shown/hidden based on saved state
    });

    // Save state on change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const columnClass = this.getAttribute('data-column');
            localStorage.setItem('column_' + columnClass, this.checked);
            toggleColumnVisibility(this);
        });
    });

    // Restore Defaults Button
    document.getElementById('restore-defaults').addEventListener('click', function() {
        console.log('Restore Defaults clicked');
        const defaultColumns = ['column-id-venta', 'column-fecha', 'column-id-evento', 'column-id-vendedor', 'column-productos-totales', 'column-tipo-de-venta', 'column-forma-de-pago', 'column-precio-total-venta']; // Columns you want to show by default

        checkboxes.forEach(checkbox => {
            const columnClass = checkbox.getAttribute('data-column');
            checkbox.checked = defaultColumns.includes(columnClass);
            console.log(`Checkbox ${columnClass} default checked: ${checkbox.checked}`);
            localStorage.setItem('column_' + columnClass, checkbox.checked);
            toggleColumnVisibility(checkbox);
        });
    });

    // Toggle column visibility
    function toggleColumnVisibility(checkbox) {
        const columnClass = checkbox.getAttribute('data-column');
        const ths = document.querySelectorAll('.grid-view th.' + columnClass);
        const tds = document.querySelectorAll('.grid-view td.' + columnClass);
        console.log(`Toggling visibility for ${columnClass}`);
        
        ths.forEach(th => {
            th.style.display = checkbox.checked ? '' : 'none';
        });
        tds.forEach(td => {
            td.style.display = checkbox.checked ? '' : 'none';
        });
    }
});

</script>