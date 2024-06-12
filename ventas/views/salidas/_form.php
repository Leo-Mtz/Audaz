<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Salidas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salidas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md col-lg">		
    
    <?= $form->field($model, 'fecha')->widget(yii\jui\DatePicker::className(), [
        'clientOptions' => [
            'showAnim' => 'fold',
            'changeMonth' => true,
            'changeYear' => true
        ],
        'options' => [
            'class' => 'form-control',
        ],
        'language' => 'es-MX',
        'dateFormat' => 'dd-MM-yyyy',
        'value' => date('dd-MM-yyyy'), // Set the default value to the current date
    ]) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'id_empleado')->dropdownList($empleados, ['prompt' => 'Seleccionar empleado']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'id_evento')->dropdownList($eventos, ['prompt' => 'Seleccionar evento']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'id_sabor')->dropdownList($sabores, ['prompt' => 'Seleccionar sabor']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_vendida')->textInput(['placeholder' => 'Cantidad vendida', 'readonly' => true]) ?>
    </div>

    <style>      
        .small-input {
            width: 150px;
        }
    </style>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_375ml')->textInput(['class' => 'small-input', 'name' => 'vendidas_375ml']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_16onz')->textInput(['class' => 'small-input', 'name' => 'vendidas_16onz']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_750ml')->textInput(['class' => 'small-input', 'name' => 'vendidas_750ml']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_2L')->textInput(['class' => 'small-input', 'name' => 'vendidas_2L']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_degustacion')->textInput() ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_2L')->textInput(['class' => 'small-input', 'name' => 'vendidas_2L']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_2L')->textInput(['class' => 'small-input', 'name' => 'vendidas_2L']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_2L')->textInput(['class' => 'small-input', 'name' => 'vendidas_2L']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_2L')->textInput(['class' => 'small-input', 'name' => 'vendidas_2L']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_cortesia')->textInput() ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_total')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
    function calcularVendidos() {
        var totales_vendidos = 0;

        // Select and iterate over quantity inputs with specific names
        $('input[name=\"vendidas_375ml\"], input[name=\"vendidas_16onz\"], input[name=\"vendidas_750ml\"], input[name=\"vendidas_2L\"]').each(function() {
            var valor = parseFloat($(this).val());
            if (!isNaN(valor)) {
                totales_vendidos += valor;
            }
        });

        $('#salidas-cantidad_vendida').val(totales_vendidos);
    }

    $(document).on('input', 'input[name=\"vendidas_375ml\"], input[name=\"vendidas_16onz\"], input[name=\"vendidas_750ml\"], input[name=\"vendidas_2L\"]', function() {
        calcularVendidos();
    });

    calcularVendidos();
");
?>
