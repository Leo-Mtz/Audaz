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

  <div class="col-md col-lg">
        <?= $form->field($model, 'productos_totales')->textInput([
            'placeholder' => 'Número de productos',
            'id' => 'num_productos',
            'oninput' => 'generateProductFields()'
        ]) ?>
    </div>
    
    
    <div id="Productosadicionales" class="mt-3 row"></div>
    <button type="button" class="btn btn-primary" onclick="addProductField()">Agregar Producto</button>



   <div class="col-md col-lg">
       <?= $form->field($model, 'precio_total_venta')->textInput(['value' => $model->precio_total_venta, 'readonly' => false]) ?>
   </div>

    <?= $form->field($model, 'id_evento')->textInput() ?>
    <?= $form->field($model, 'id_vendedor')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <?=$form->field($model, 'tipo_de_venta')->dropDownList([
        'prompt'=>  "Tipo de venta",
        'venta'=>'Venta',
        'degustacion'=>'Degustacion',
        'cortesia'=>'Cortesía',

    ], ['class'=>'form-control'])?>

    <?= $form->field($model, 'forma_de_pago')->dropDownList([
        'prompt' => 'Selecciona una forma de pago',
        'efectivo' => 'Efectivo',
        'tarjeta' => 'Tarjeta de Crédito/Débito',
        'transferencia' => 'Transferencia Bancaria',
        
    ], ['class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
// Arreglo de productos para el dropdown
const productosDropdown = <?= json_encode($productosDropdown) ?>;

// Contador para llevar la cuenta de los productos agregados dinámicamente
let productCount = 0;


function generateProductFields() {
    const numProductos = parseInt(document.getElementById('num_productos').value) || 0;
    const ProductFieldsContainer = document.getElementById('Productosadicionales');
    ProductFieldsContainer.innerHTML = ''; // Clear existing fields

    for (let i = 0; i < numProductos; i++) {
        addProductField(i);
    }
}


// Función para agregar campos de productos adicionales dinámicamente
function addProductField(index) {
    // Obtener el contenedor donde se agregarán los campos de producto
    const ProductFieldsContainer = document.getElementById('Productosadicionales');

    // Crear un nuevo div para cada par de campos con estilos de Bootstrap
    const productDiv = document.createElement('div');
    productDiv.className = 'col-md-12 mb-2';

    // Crear un div de fila para alinear los campos de lado a lado
    const rowDiv = document.createElement('div');
    rowDiv.className = 'row';

    // Crear un div para el campo de id_producto con clases de Bootstrap
    const divIdProducto = document.createElement('div');
    divIdProducto.className = 'col-md-4';

    // Crear un select para id_producto
    const idProductoField = document.createElement('select');
    idProductoField.name = 'Ventas[productos][' + productCount + '][id_producto]';
    idProductoField.className = 'form-control mb-2';
    idProductoField.onchange = function() { updatePrecioUnitario(this); }; // Evento al cambiar seleccion

    // Opción predeterminada para el select
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = 'Seleccionar producto';
    idProductoField.appendChild(defaultOption);

    // Agregar opciones al dropdown de productos
    for (const key in productosDropdown) {
        if (productosDropdown.hasOwnProperty(key)) {
            const option = document.createElement('option');
            option.value = key;
            option.text = productosDropdown[key];
            idProductoField.appendChild(option);
        }
    }

    divIdProducto.appendChild(idProductoField);

    // Crear un div para el campo de cantidad_vendida
    const divCantidadVendida = document.createElement('div');
    divCantidadVendida.className = 'col-md-4';

    // Crear un input de tipo número para cantidad_vendida
    const cantidadVendidaField = document.createElement('input');
    cantidadVendidaField.type = 'number';
    cantidadVendidaField.name = 'Ventas[productos][' + productCount + '][cantidad_vendida]';
    cantidadVendidaField.className = 'form-control mb-2 cantidad-vendida-input';
    cantidadVendidaField.placeholder = 'Cantidad Vendida';
    cantidadVendidaField.oninput = function() { calcularMontoProducto(this); }; // Evento al escribir

    divCantidadVendida.appendChild(cantidadVendidaField);

    // Crear un div para el campo de precio_total_producto
    const divPrecioTotalProducto = document.createElement('div');
    divPrecioTotalProducto.className = 'col-md-4';

    // Crear un input de tipo número para precio_total_producto
    const precioTotalProductoField = document.createElement('input');
    precioTotalProductoField.type = 'number';
    precioTotalProductoField.name = 'Ventas[productos][' + productCount + '][precio_total_producto]';
    precioTotalProductoField.className = 'form-control mb-2 precio-total-producto-input';
    precioTotalProductoField.placeholder = 'Precio total por producto';
    precioTotalProductoField.readOnly = true; // Campo solo lectura
    precioTotalProductoField.oninput = calcularTotalVenta; // Evento al escribir

    divPrecioTotalProducto.appendChild(precioTotalProductoField);

    // Añadir los divs de id_producto, cantidad_vendida y precio_total_producto a la fila
    rowDiv.appendChild(divIdProducto);
    rowDiv.appendChild(divCantidadVendida);
    rowDiv.appendChild(divPrecioTotalProducto);

    // Añadir la fila y el botón de eliminar al div de producto
    productDiv.appendChild(rowDiv);

    // Crear un botón para eliminar el campo de producto
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn btn-danger btn-sm';
    deleteButton.textContent = 'Eliminar Campo';
    deleteButton.addEventListener('click', function() {
        ProductFieldsContainer.removeChild(productDiv); // Eliminar el div del producto al hacer clic en el botón
        calcularTotalVenta(); // Recalcular el total de la venta después de eliminar un producto
    });

    // Añadir el botón de eliminar al div de producto
    productDiv.appendChild(deleteButton);

    // Añadir el div de producto al contenedor principal
    ProductFieldsContainer.appendChild(productDiv);

    // Incrementar el contador de productos para el siguiente campo
    productCount++;
}

// Función para actualizar el precio unitario al cambiar el producto seleccionado
function updatePrecioUnitario(element) {
    const selectedOption = element.value;
    const rowDiv = element.closest('.row'); // Obtener el div de fila que contiene los campos
    const precioUnitarioField = rowDiv.querySelector('.precio-unitario-input'); // Campo de precio unitario
    const cantidadVendidaField = rowDiv.querySelector('.cantidad-vendida-input'); // Campo de cantidad vendida

    // Realizar una solicitud AJAX para obtener el precio unitario del producto seleccionado
    $.ajax({
        url: '<?= Url::to(['ventas/get-precio-unitario']) ?>',
        data: { id: selectedOption },
        success: function(response) {
            const data = JSON.parse(response);
            precioUnitarioField.value = data.precio; // Asignar el precio unitario obtenido al campo correspondiente
            calcularMontoProducto(cantidadVendidaField); // Calcular el monto del producto después de actualizar el precio unitario
        },
        error: function() {
            precioUnitarioField.value = ''; // Limpiar el campo si hay un error
            calcularMontoProducto(cantidadVendidaField); // Calcular el monto del producto con el precio unitario vacío
        }
    });
}

// Función para calcular el monto total del producto
function calcularMontoProducto(element) {
    const rowDiv = element.closest('.row'); // Obtener el div de fila que contiene los campos
    const precioUnitarioField = rowDiv.querySelector('.precio-unitario-input'); // Campo de precio unitario
    const cantidadVendidaField = rowDiv.querySelector('.cantidad-vendida-input'); // Campo de cantidad vendida
    const precioTotalProductoField = rowDiv.querySelector('.precio-total-producto-input'); // Campo de precio total por producto

    // Calcular el monto del producto multiplicando el precio unitario por la cantidad vendida
    const precio_unitario = parseFloat(precioUnitarioField ? precioUnitarioField.value : 0) || 0;
    const cantidad_vendida = parseFloat(cantidadVendidaField ? cantidadVendidaField.value : 0) || 0;
    const monto_producto = precio_unitario * cantidad_vendida;

    // Mostrar el monto calculado en el campo de precio total por producto
    precioTotalProductoField.value = monto_producto.toFixed(2);

    // Calcular el total de la venta después de actualizar el monto del producto
    calcularTotalVenta();
}

// Función para calcular el total de la venta sumando los precios totales de todos los productos
function calcularTotalVenta() {
    let totalVenta = 0;
    let totalCantidadVendida = 0;

    // Iterar sobre todos los campos de precio total por producto y cantidad vendida para calcular el total de la venta
    document.querySelectorAll('.precio-total-producto-input').forEach(function(element) {
        const value = parseFloat(element.value);
        if (!isNaN(value)) {
            totalVenta += value;
        }
    });

    document.querySelectorAll('.cantidad-vendida-input').forEach(function(element) {
        const cantidadVendida = parseFloat(element.value);
        if (!isNaN(cantidadVendida)) {
            totalCantidadVendida += cantidadVendida;
        }
    });

    // Mostrar el total de la cantidad vendida y el total de la venta en los campos correspondientes
    document.getElementById('total_vendida').value = totalCantidadVendida.toFixed(2);
    document.getElementById('precio_total_venta').value = totalVenta.toFixed(2);
}
</script>
