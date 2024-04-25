<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Salidas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salidas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_salidas')->textInput() ?>

    <?= $form->field($model, 'id_empleado')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'id_evento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_producto')->textInput() ?>

    <?= $form->field($model, 'cantidad_vendida')->textInput() ?>

    <?= $form->field($model, 'cantidad_degustacion')->textInput() ?>

    <?= $form->field($model, 'cantidad_cortesia')->textInput() ?>

    <?= $form->field($model, 'cantidad_total')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
