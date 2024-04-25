<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntradasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entradas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_entradas') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'id_empleado') ?>

    <?= $form->field($model, 'id_evento') ?>

    <?= $form->field($model, 'id_producto') ?>

    <?php // echo $form->field($model, 'cantidad_entradas') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
