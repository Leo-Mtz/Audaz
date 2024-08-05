<?php
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\ReporteVentas */
/* @var $ventasDiarias array */

$this->title = 'Reportes Diarios de Ventas';
?>

<div class="reporte-ventas-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $ventasDiarias,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            [
                'attribute' => 'fecha',
                'label' => 'Fecha',
                'value' => function ($data) {
                    return Html::encode($data['fecha']);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {download} {download-pdf}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver Reporte', ['generar-pdf', 'fecha' => $model['fecha']], ['class' => 'btn btn-info']);
                    },
                    'download' => function ($url, $model) {
                        return Html::a('Descargar Excel', ['descargar-reporte', 'fecha' => $model['fecha']], ['class' => 'btn btn-success']);
                    },
                    'download-pdf' => function ($url, $model) {
                        return Html::a('Descargar PDF', ['descargar-pdf', 'fecha' => $model['fecha']], ['class' => 'btn btn-success']);
                    },
                ],

            ],
        ],
    ]); ?>
</div>
