<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Entradas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entradas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md col-lg">
        <?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
            'clientOptions' => [
                'showAnim' => 'fold',
                'changeMonth' => true,
                'changeYear' => true
            ],
            'options' => ['class' => 'form-control'],
            'language' => 'es-MX',
            'dateFormat' => 'yyyy-MM-dd',
            'value' => date('yyyy-MM-dd'), // Set the default value to the current date
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
        <?= Html::label('Presentaciones', 'presentaciones', ['class' => 'label-class']) ?>
    </div>

    <?= $form->field($model, 'id_prueba')->hiddenInput(['value' => $prueba])->label(false) ?>
    <?= $form->field($model, 'id_375ml')->hiddenInput(['value' => $ml375])->label(false) ?>
    <?= $form->field($model, 'id_750ml')->hiddenInput(['value' => $ml750])->label(false) ?>
    <?= $form->field($model, 'id_16onz')->hiddenInput(['value' => $onz16])->label(false) ?>
    <?= $form->field($model, 'id_2L')-> hiddenInput(['value'=>$DosLitros])->label(false)?>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_pruebas')->textInput(['placeholder' => 'Cantidad Pruebas', 'class' => 'quantity-input']) ?>
    </div>


    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_375ml')->textInput(['placeholder' => 'Cantidad 375ml', 'class' => 'quantity-input']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_750ml')->textInput(['placeholder' => 'Cantidad 750ml', 'class' => 'quantity-input']) ?>
    </div>

    <?= var_dump($prueba) ?>
    <?=var_dump($ml375) ?>
    <?=var_dump($ml750) ?>
    <?=var_dump($onz16) ?>
    <?=var_dump($DosLitros) ?>
    

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_16onz')->textInput(['placeholder' => 'Cantidad 16onz', 'class' => 'quantity-input']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_2L')->textInput(['placeholder' => 'Cantidad 2L', 'class' => 'quantity-input']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_entradas')->textInput(['placeholder' => 'Cantidad Total', 'readonly' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
    function calculateTotal() {
        var total = 0;
        $('.quantity-input').each(function() {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                total += value;
            }
        });
        $('#entradas-cantidad_entradas').val(total);
    }

    $('.quantity-input').on('input', function() {
        calculateTotal();
    });

    // Initial calculation
    calculateTotal();
");
?>
