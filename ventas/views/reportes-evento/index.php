<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $reportes array */

$this->title = 'Reportes por Evento';
?>

<div class="reporte-evento-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $ventasPorEvento,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            [
                'attribute' => 'evento',
                'label' => 'Evento',
                'value' => function ($data) {
                    return Html::encode($data['evento']);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {download} {download-pdf}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver Reporte', ['ver-pdf', 'id_evento' => $model['id_evento']], ['target' => '_blank', 'class' => 'btn btn-info']);
                    },
                    'download' => function ($url, $model) {
                        return Html::a('Descargar Excel', ['descargar-reporte', 'id_evento' => $model['id_evento']], ['class' => 'btn btn-success']);
                    },
                    'download-pdf' => function ($url, $model) {
                        return Html::a('Descargar PDF', ['descargar-pdf', 'id_evento' => $model['id_evento']], ['class' => 'btn btn-success']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
