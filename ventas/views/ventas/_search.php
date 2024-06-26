<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VentasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ventas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_venta') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'id_producto') ?>

    <?= $form->field($model, 'cantidad_vendida') ?>

    <?= $form->field($model, 'precio_total_venta') ?>

    <?php // echo $form->field($model, 'id_evento') ?>

    <?php // echo $form->field($model, 'id_vendedor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
