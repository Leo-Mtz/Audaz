<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalidasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salidas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_salidas') ?>

    <?= $form->field($model, 'id_empleado') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'id_evento') ?>

    <?= $form->field($model, 'id_producto') ?>

    <?php // echo $form->field($model, 'cantidad_vendida') ?>

    <?php // echo $form->field($model, 'cantidad_degustacion') ?>

    <?php // echo $form->field($model, 'cantidad_cortesia') ?>

    <?php // echo $form->field($model, 'cantidad_total') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
