<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ExigiblesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exigibles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'rfc') ?>

    <?= $form->field($model, 'razon_social') ?>

    <?= $form->field($model, 'tipo_persona') ?>

    <?= $form->field($model, 'supuesto') ?>

    <?php // echo $form->field($model, 'fecha_primera_publicacion') ?>

    <?php // echo $form->field($model, 'entidad_federativa') ?>

    <?php // echo $form->field($model, 'fecha_hora_registro') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
