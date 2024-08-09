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
/* @var $sabores array */
/* @var $presentacionesList array */


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="entradas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
                'clientOptions' => [
                    'showAnim' => 'fold',
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'class' => 'form-control',
                    'id' => 'fecha-input',
                ],
                'language' => 'es-MX',
                'dateFormat' => 'yyyy-MM-dd',
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
    document.addEventListener("DOMContentLoaded", function() {
        // Get the client's current date and time
        var clientDate = new Date();

        // Format the date to yyyy-mm-dd in the local time zone
        var year = clientDate.getFullYear();
        var month = (clientDate.getMonth() + 1).toString().padStart(2, '0');
        var day = clientDate.getDate().toString().padStart(2, '0');
        var formattedDate = year + '-' + month + '-' + day;

        // Set the date in the form field
        document.getElementById('fecha-input').value = formattedDate;
        console.log(clientDate);
    });


    </script>

<script>

    let entradaCount=0;
    function generateEntradaFields() {
    const numEntradas = parseInt(document.getElementById('num_entradas').value) || 0;
    const container = document.getElementById('Entradasadicionales');
    container.innerHTML = '';

    for (let i = 0; i < numEntradas; i++) {
        const div = document.createElement('div');
        div.className = 'col-md-4 col-lg-4';

        div.innerHTML = `
            <div class="form-group">
                <label for="entrada${i}-sabor">Sabor:</label>
                <select name="Entradas[entradas][${i}][id_sabor]" id="entrada${i}-sabor" class="form-control" onchange="fetchPresentaciones(this, ${i})">
                    <option value="">Seleccionar sabor</option>
                    <?php foreach ($sabores as $id_sabor => $sabor): ?>
                        <option value="<?= $id_sabor ?>"><?= $sabor ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="entrada${i}-presentacion">Presentación:</label>
                <select name="Entradas[entradas][${i}][id_presentacion]" id="entrada${i}-presentacion" class="form-control">
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="entrada${i}-cantidad">Cantidad:</label>
                <input type="number" name="Entradas[entradas][${i}][cantidad_entradas_producto]" id="entrada${i}-cantidad" class="form-control quantity-input" oninput="calcularTotal()">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeEntradaField(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(div);
    }

    // Update the entradas_totales field with the number of fields
    document.getElementById('entradas_totales').value = numEntradas;

    calcularTotal();
}

function addEntradaField() {
    const container = document.getElementById('Entradasadicionales');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className = 'col-md-4 col-lg-4';

    div.innerHTML = `
        <div class="form-group">
            <label for="entrada${index}-sabor">Sabor:</label>
            <select name="Entradas[entradas][${index}][id_sabor]" id="entrada${index}-sabor" class="form-control" onchange="fetchPresentaciones(this, ${index})">
                <option value="">Seleccionar sabor</option>
                <?php foreach ($sabores as $id_sabor => $sabor): ?>
                    <option value="<?= $id_sabor ?>"><?= $sabor ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="entrada${index}-presentacion">Presentación:</label>
            <select name="Entradas[entradas][${index}][id_presentacion]" id="entrada${index}-presentacion" class="form-control">
                <!-- Options will be populated by JavaScript -->
            </select>
        </div>
        <div class="form-group">
            <label for="entrada${index}-cantidad">Cantidad:</label>
            <input type="number" name="Entradas[entradas][${index}][cantidad_entradas_producto]" id="entrada${index}-cantidad" class="form-control quantity-input" oninput="calcularTotal()">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeEntradaField(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(div);

    // Update the entradas_totales field with the new total
    const entradasTotales = container.children.length;
    document.getElementById('num_entradas').value = entradasTotales;

    calcularTotal();
}

function removeEntradaField(button) {
    const container = document.getElementById('Entradasadicionales');
    const fieldDiv = button.closest('.col-md-4');
    container.removeChild(fieldDiv);

    // Update the entradas_totales field with the new total
    const entradasTotales = container.children.length;
    document.getElementById('num_entradas').value = entradasTotales;

    calcularTotal();
}
    function fetchPresentaciones(selectElement, entryIndex) {
        const saborId = selectElement.value;
        console.log(`Selected sabor ID: ${saborId}`);

        if (!saborId) {
            const presentacionField = document.querySelector(`#entrada${entryIndex}-presentacion`);
            presentacionField.innerHTML = '<option value="">Seleccionar presentación</option>';
            console.log('Presentacion field cleared');
            return;
        }

        console.log('Fetching presentaciones for sabor ID:', saborId);

        $.ajax({
            url: '<?= Url::to(['entradas/get-presentaciones']) ?>',
            type: 'GET',
            data: { idSabor: saborId },
            dataType: 'json',
            success: function(data) {
                console.log('Received presentaciones:', data);

                const presentacionField = document.querySelector(`#entrada${entryIndex}-presentacion`);
                presentacionField.innerHTML = '<option value="">Seleccionar presentación</option>';

                if (data.error) {
                    console.error('Error from server:', data.error);
                    return;
                }

                for (const [id, presentacion] of Object.entries(data)) {
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = presentacion;
                    presentacionField.appendChild(option);
                }

                // Log the updated dropdown value
                console.log('Updated presentacion field:', presentacionField.innerHTML);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching presentaciones:', error);
            }
        });
    }

    function calcularTotal() {
    let total = 0;
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        const value = parseFloat(input.value) || 0;
        total += value;
    });
    document.getElementById('cantidad_entradas').value = total; 
    
    }

    
function validateNonNegativeValues() {
    const entradasTotalesInput = document.getElementById('num_entradas');
    const cantidadEntradasInput = document.getElementById('cantidad_entradas');
    
    // Validate entradas_totales
    if (parseFloat(entradasTotalesInput.value) < 0) {
        entradasTotalesInput.value = 0;
    }

    // Validate cantidad_entradas_producto in each input field
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        if (parseFloat(input.value) < 0) {
            input.value = 0;
        }
    });

    // Recalculate total after validation
    calcularTotal();
}

// Call validation on input changes and form submission
document.addEventListener('input', function(event) {
    if (event.target.matches('#num_entradas') || event.target.matches('.quantity-input')) {
        validateNonNegativeValues();
    }
});
</script>

