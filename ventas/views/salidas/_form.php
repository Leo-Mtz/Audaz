<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Salidas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salidas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md col-lg">        
        <?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
            'clientOptions' => [
                'showAnim' => 'fold',
                'changeMonth' => true,
                'changeYear' => true
            ],
            'options' => [
                'class' => 'form-control',
            ],
            'language' => 'es-MX',
            'dateFormat' => 'yyyy-MM-dd',
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
        <?= $form->field($model, 'cantidad_vendida')->textInput(['readonly' => true]) ?>
    </div>

    <style>      
        .small-input {
            width: 150px;
        }
    </style>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_375ml')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_16onz')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_750ml')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'vendidas_2L')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_degustacion')->textInput(['readonly' => true]) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'degustacion_375ml')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'degustacion_16onz')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'degustacion_750ml')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'degustacion_2L')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_cortesia')->textInput(['readonly' => true]) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'cortesia_375ml')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'cortesia_16onz')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'cortesia_750ml')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg" style="margin-left: 50px;">
        <?= $form->field($model, 'cortesia_2L')->textInput(['class' => 'small-input']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_total')->textInput(['readonly' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
    function calcularVendidos() {
        var totales_vendidos = 0;

        $('input[name=\"Salidas[vendidas_375ml]\"], input[name=\"Salidas[vendidas_16onz]\"], input[name=\"Salidas[vendidas_750ml]\"], input[name=\"Salidas[vendidas_2L]\"]').each(function() {
            var valor = parseFloat($(this).val());
            if (!isNaN(valor)) {
                totales_vendidos += valor;
            }
        });

        $('#salidas-cantidad_vendida').val(totales_vendidos);
    }

    $(document).on('input', 'input[name=\"Salidas[vendidas_375ml]\"], input[name=\"Salidas[vendidas_16onz]\"], input[name=\"Salidas[vendidas_750ml]\"], input[name=\"Salidas[vendidas_2L]\"]', function() {
        calcularVendidos();
    }); 

    calcularVendidos();
");

$this->registerJs("
    function calcularDegustados() {
        var totales_degustados = 0;

        $('input[name=\"Salidas[degustacion_375ml]\"], input[name=\"Salidas[degustacion_16onz]\"], input[name=\"Salidas[degustacion_750ml]\"], input[name=\"Salidas[degustacion_2L]\"]').each(function() {
            var valor_degustados = parseFloat($(this).val());
            if (!isNaN(valor_degustados)) {
                totales_degustados += valor_degustados;
            }
        });

        $('#salidas-cantidad_degustacion').val(totales_degustados);
    }

    $(document).on('input', 'input[name=\"Salidas[degustacion_375ml]\"], input[name=\"Salidas[degustacion_16onz]\"], input[name=\"Salidas[degustacion_750ml]\"], input[name=\"Salidas[degustacion_2L]\"]', function() {
        calcularDegustados();
    });

    calcularDegustados();
");

$this->registerJs("
    function calcularCortesia() {
        var totales_cortesia = 0;

        $('input[name=\"Salidas[cortesia_375ml]\"], input[name=\"Salidas[cortesia_16onz]\"], input[name=\"Salidas[cortesia_750ml]\"], input[name=\"Salidas[cortesia_2L]\"]').each(function() {
            var valor_cortesia = parseFloat($(this).val());
            if (!isNaN(valor_cortesia)) {
                totales_cortesia += valor_cortesia;
            }
        });

        $('#salidas-cantidad_cortesia').val(totales_cortesia);
    }

    $(document).on('input', 'input[name=\"Salidas[cortesia_375ml]\"], input[name=\"Salidas[cortesia_16onz]\"], input[name=\"Salidas[cortesia_750ml]\"], input[name=\"Salidas[cortesia_2L]\"]', function() {
        calcularCortesia();
    });

    calcularCortesia();
");

$this->registerJs("
    function calcularTotalSalidas() {
        var total_vendida = parseFloat($('#salidas-cantidad_vendida').val()) || 0;
        var total_degustacion = parseFloat($('#salidas-cantidad_degustacion').val()) || 0;
        var total_cortesia = parseFloat($('#salidas-cantidad_cortesia').val()) || 0;

        var salidas_totales = total_vendida + total_degustacion + total_cortesia;

        $('#salidas-cantidad_total').val(salidas_totales);
    }

    $(document).on('input', 'input[name^=\"Salidas[vendidas_\"]', function() {
        calcularVendidos();
        calcularDegustados();
        calcularCortesia();
        calcularTotalSalidas();
    });

    $(document).on('input', 'input[name^=\"Salidas[degustacion_\"]', function() {
        calcularVendidos();
        calcularDegustados();
        calcularCortesia();
        calcularTotalSalidas();
    });

    $(document).on('input', 'input[name^=\"Salidas[cortesia_\"]', function() {
        calcularVendidos();
        calcularDegustados();
        calcularCortesia();
        calcularTotalSalidas();
    });

    calcularTotalSalidas();
");
?>
