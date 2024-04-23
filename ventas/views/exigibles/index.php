<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExigiblesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exigibles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exigibles-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'rfc',
            'razon_social',
            'tipo_persona',
            'fecha_primera_publicacion',
            'entidad_federativa',
            //'fecha_hora_registro',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
