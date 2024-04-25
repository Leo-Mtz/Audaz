<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntradasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entradas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entradas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Entradas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_entradas',
            'fecha',
            'id_empleado',
            'id_evento',
            'id_producto',
            //'cantidad_entradas',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
