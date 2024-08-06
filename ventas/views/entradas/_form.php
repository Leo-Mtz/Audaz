<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Entradas */
/* @var $form yii\widgets\ActiveForm */
/* @var $empleados array */
/* @var $eventos array */

?>

<div class="entradas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row mt-3">
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
                'clientOptions' => [
                    'showAnim' => 'fold',
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => ['class' => 'form-control'],
                'language' => 'es-MX',
                'dateFormat' => 'yy-mm-dd',
                'value' => date('Y-m-d'), // Set the default value to the current date
            ]) ?>
        </div>

        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'id_empleado')->dropDownList($empleados, ['prompt' => 'Seleccionar empleado']) ?>
        </div>

        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'id_evento')->dropDownList($eventos, ['prompt' => 'Seleccionar evento']) ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3 col-lg-2">
            <?= $form->field($model, 'entradas_totales')->textInput([
                'placeholder' => 'Número de entradas',
                'id' => 'num_entradas',
                'oninput' => 'generateEntradaFields()'
            ]) ?>
        </div>
    </div>

    <div id="Entradasadicionales" class="mt-3 row"></div>
    <button type="button" class="btn btn-primary" onclick="addEntradaField()">Agregar Entrada</button>

    <div class="row mt-3">
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'cantidad_entradas')->textInput(['placeholder' => 'Cantidad Total', 'readonly' => true, 'id' => 'cantidad_entradas']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    let entradaCount = 0;

    function generateEntradaFields() {
        const numEntradas = parseInt(document.getElementById('num_entradas').value) || 0;
        const entradasContainer = document.getElementById('Entradasadicionales');
        const currentFields = entradasContainer.childElementCount;

        if (numEntradas === 0) {
            entradasContainer.innerHTML = '';
            entradaCount = 0;
            calcularTotal();
            return;
        }

        if (numEntradas > currentFields) {
            for (let i = currentFields; i < numEntradas; i++) {
                addEntradaField();
            }
        } else if (numEntradas < currentFields) {
            for (let i = currentFields; i > numEntradas; i--) {
                entradasContainer.removeChild(entradasContainer.lastChild);
                entradaCount--;
            }
            calcularTotal();
        }
    }

    function addEntradaField() {
        const entradasContainer = document.getElementById('Entradasadicionales');
        const fieldDiv = document.createElement('div');
        fieldDiv.className = 'col-md-12 mb-2';

        const rowDiv = document.createElement('div');
        rowDiv.className = 'row';

        const divCantidad = document.createElement('div');
        divCantidad.className = 'col-md-3';

        const cantidadField = document.createElement('input');
        cantidadField.type = 'number';
        cantidadField.name = 'Entradas[entradas][' + entradaCount + '][cantidad]';
        cantidadField.className = 'form-control mb-2 quantity-input';
        cantidadField.placeholder = 'Cantidad';
        cantidadField.oninput = function() {
            calcularTotal();
        };

        divCantidad.appendChild(cantidadField);

        const divDescripcion = document.createElement('div');
        divDescripcion.className = 'col-md-6';

        const descripcionField = document.createElement('input');
        descripcionField.type = 'text';
        descripcionField.name = 'Entradas[entradas][' + entradaCount + '][descripcion]';
        descripcionField.className = 'form-control mb-2';
        descripcionField.placeholder = 'Descripción';

        divDescripcion.appendChild(descripcionField);

        const divRemove = document.createElement('div');
        divRemove.className = 'col-md-3';

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm';
        removeButton.innerHTML = '<i class="fas fa-trash"></i>';
        removeButton.onclick = function() {
            entradasContainer.removeChild(fieldDiv);
            entradaCount--;
            document.getElementById('num_entradas').value = entradaCount;
  
        };

        divRemove.appendChild(removeButton);

        rowDiv.appendChild(divCantidad);
        rowDiv.appendChild(divDescripcion);
        rowDiv.appendChild(divRemove);

        fieldDiv.appendChild(rowDiv);
        entradasContainer.appendChild(fieldDiv);
        entradaCount++;
        document.getElementById('num_entradas').value = entradaCount;
    }

    function calcularTotal() {
        let total = 0;
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        document.getElementById('cantidad_entradas').value = total;

        // Actualizar el campo entradas_totales con el total calculado
        document.getElementById('entradas_totales').value = total;
    }

    // Inicializar la función calcularTotal en caso de que ya haya campos al cargar la página
    calcularTotal();

</script>
