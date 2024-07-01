<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */
/* @var $form yii\widgets\ActiveForm */
/* @var $productosDropdown array */
?>


<div class="ventas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md col-lg">
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

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'id_producto')->dropdownList($productosDropdown, [
                'prompt' => 'Seleccionar producto',
                'id' => 'id_producto',
                'onchange' => 'updatePrecioUnitario()',
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'cantidad_vendida')->textInput(['class' => 'form-control cantidad-vendida-input', 'id' => 'cantidad_vendida']) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'precio_unitario')->hiddenInput(['class' => 'form-control precio-unitario-input', 'id' => 'precio_unitario', 'readonly' => true, 'label'=>false]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'precio_total_producto')->textInput(['class'=>'precio-total-producto-input','id' => 'precio_total_producto', 'readonly' => true]) ?>
        </div>
    </div>

    <div id="Productosadicionales" class="mt-3 row"></div>
    <button type="button" class="btn btn-primary" onclick="addProductField()">Agregar Producto</button>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_total_vendida')->textInput(['placeholder' => 'Total Vendida', 'id'=> 'total_vendida', 'readonly' => true]) ?>
    </div>

   <div class="col-md col-lg">
       <?= $form->field($model, 'precio_total_venta')->textInput(['value' => $model->precio_total_venta, 'readonly' => true]) ?>
   </div>

    <?= $form->field($model, 'id_evento')->textInput() ?>
    <?= $form->field($model, 'id_vendedor')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <?= $form->field($model, 'forma_de_pago')->dropDownList([
        'prompt' => 'Selecciona una forma de pago',
        'efectivo' => 'Efectivo',
        'tarjeta' => 'Tarjeta de Crédito/Débito',
        'transferencia' => 'Transferencia Bancaria',
        'paypal' => 'PayPal',
    ], ['class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
function updatePrecioUnitario() { //funcion para mostrar el precio unitario de cada producto
    const selectedOption = document.getElementById('id_producto').value;
    const precioUnitarioField = document.getElementById('precio_unitario');

    // Perform AJAX request to get the price
    $.ajax({
        url: '<?= Url::to(['ventas/get-precio-unitario']) ?>',
        data: { id: selectedOption },
        success: function(response) {
            const data = JSON.parse(response);
            precioUnitarioField.value = data.precio;
            calcularMontoProducto(); // Recalculate the total product price after updating the unit price
        },
        error: function() {
            precioUnitarioField.value = ''; // Reset if there's an error
            calcularMontoProducto(); // Recalculate the total product price with the updated (empty) unit price
        }
    });


    
}

function calcularMontoProducto() {
        var precio_unitario = parseFloat($('#precio_unitario').val()) || 0;
        var cantidad_vendida = parseFloat($('#cantidad_vendida').val()) || 0;
        var monto_producto = precio_unitario * cantidad_vendida;
        $('#precio_total_producto').val(monto_producto.toFixed(2));
        calcularTotalVenta();
    }

    function calcularTotalVenta() {
        var totalVenta = 0;
        var totalCantidadVendida = 0; // Initialize totalCantidadVendida
    
        $('.precio-total-producto-input').each(function() {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                totalVenta += value;
            }
        });
    
        // Calculate total cantidad vendida
        $('.cantidad-vendida-input').each(function() {
            var cantidadVendida = parseFloat($(this).val());
            if (!isNaN(cantidadVendida)) {
                totalCantidadVendida += cantidadVendida;
            }
        });
    

        console.log('Total Venta:', totalVenta.toFixed(2));
        console.log('Total Cantidad Vendida:', totalCantidadVendida);

        // Update the total cantidad vendida field
        $('#cantidad_total_vendida').val(totalCantidadVendida);
    
        $('#precio_total_venta').val(totalVenta.toFixed(2));
      
    }

</script>


<script>
const productosDropdown = <?= json_encode($productosDropdown) ?>;
let productCount = 0; // Initialize productCount

function addProductField() {
    const ProductFieldsContainer = document.getElementById('Productosadicionales');

    // Create a div to hold each pair of fields with col-md-12 class
    const productDiv = document.createElement('div');
    productDiv.className = 'col-md-12 mb-2'; // Apply Bootstrap grid class and margin bottom

    // Create a row div to ensure fields are side by side
    const rowDiv = document.createElement('div');
    rowDiv.className = 'row';

    // Create div for id_producto field with col-md-4 class
    const divIdProducto = document.createElement('div');
    divIdProducto.className = 'col-md-4';

    // Create a select input for id_producto
    const idProductoField = document.createElement('select');
    idProductoField.name = 'Ventas[productos][' + productCount + '][id_producto]'; // Set the name attribute for form submission
    idProductoField.className = 'form-control mb-2'; // Add a class for styling

    // Create a default option
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = 'Seleccionar producto';
    idProductoField.appendChild(defaultOption);

    for (const key in productosDropdown) {
        if (productosDropdown.hasOwnProperty(key)) {
            const option = document.createElement('option');
            option.value = key;
            option.text = productosDropdown[key];
            idProductoField.appendChild(option);
        }
    }

    // Append id_producto input to divIdProducto
    divIdProducto.appendChild(idProductoField);

    // Create div for cantidad_vendida field with col-md-4 class
    const divCantidadVendida = document.createElement('div');
    divCantidadVendida.className = 'col-md-4';

    // Create a text input for cantidad_vendida
    const cantidadVendidaField = document.createElement('input');
    cantidadVendidaField.type = 'number';
    cantidadVendidaField.name = 'Ventas[productos][' + productCount + '][cantidad_vendida]'; // Set the name attribute for form submission
    cantidadVendidaField.className = 'form-control mb-2 cantidad-vendida-input'; // Add a class for styling
    cantidadVendidaField.placeholder = 'Cantidad Vendida';

    
    // Append cantidad_vendida input to divCantidadVendida
    divCantidadVendida.appendChild(cantidadVendidaField);

    // Create div for precio_total_producto field with col-md-4 class
    const divPrecioTotalProducto = document.createElement('div');
    divPrecioTotalProducto.className = 'col-md-4';

    const PrecioTotalProducto = document.createElement('input');
    PrecioTotalProducto.type = 'number';
    PrecioTotalProducto.name = 'Ventas[productos][' + productCount + '][precio_total_producto]';
    PrecioTotalProducto.className = 'form-control mb-2 precio-total-producto-input';
    PrecioTotalProducto.placeholder = 'Precio total por producto';
    PrecioTotalProducto.readOnly = true;
    PrecioTotalProducto.oninput = calcularTotalVenta;

    divPrecioTotalProducto.appendChild(PrecioTotalProducto);

    rowDiv.appendChild(divIdProducto);
    rowDiv.appendChild(divCantidadVendida);
    rowDiv.appendChild(divPrecioTotalProducto);

    // Append rowDiv to productDiv
    productDiv.appendChild(rowDiv);

    // Create delete button
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn btn-danger btn-sm'; // Bootstrap button classes for styling
    deleteButton.textContent = 'Eliminar Campo'; // Button text

    // Add click event listener to delete button
    deleteButton.addEventListener('click', function() {
        ProductFieldsContainer.removeChild(productDiv); // Remove the entire productDiv when delete button is clicked
    });

    // Append delete button to productDiv
    productDiv.appendChild(deleteButton);

    // Append productDiv (col-md-12) to ProductFieldsContainer
    ProductFieldsContainer.appendChild(productDiv);

    productCount++; // Increment productCount for the next field
}
</script>