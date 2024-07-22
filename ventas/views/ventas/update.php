<?php   

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\CatProductos;
use app\models\ProductosPorVenta;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Actualizar Venta: ' . $model->id_venta;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_venta, 'url' => ['view', 'id' => $model->id_venta]];
$this->params['breadcrumbs'][] = 'Actualizar';

$id_evento = Yii::$app->session->get('id_evento'); // Retrieve id_evento from session

?>

<div class="ventas-update">

    <h1><?= Html::encode($this->title) ?></h1>

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
    <?= $form->field($model, 'cantidad_total_vendida')->textInput(['placeholder' => 'Total Vendida', 'id' => 'total_vendida', 'readonly' => true]) ?>
</div>

<div class="col-md col-lg">
    <?= $form->field($model, 'precio_total_venta')->textInput(['placeholder' => 'Monto Total', 'id' => 'total_venta', 'readonly' => true]) ?>
</div>

<div class="col-md col-lg">
    <?= $form->field($model, 'id_evento')->hiddenInput(['id' => 'id_evento_input', 'value' => $id_evento])->label(false) ?>
</div>

<?= $form->field($model, 'id_vendedor')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

<?= $form->field($model, 'tipo_de_venta')->dropDownList([
    'venta' => 'Venta',
    'degustacion' => 'Degustación',
    'cortesia' => 'Cortesía',
], ['prompt' => 'Seleccione tipo de venta']) ?>

<?= $form->field($model, 'forma_de_pago')->dropDownList([
    'efectivo' => 'Efectivo',
    'tarjeta' => 'Tarjeta de Crédito/Débito',
    'transferencia' => 'Transferencia Bancaria',
], ['prompt' => 'Seleccione una forma de pago']) ?>

<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>

<script>
const productosDropdown = <?= json_encode($productosDropdown) ?>;
let productCount = 0;
let selectedEventoId = null;
const existingProductData = <?= json_encode($existingProductData) ?>;

function generateProductFields() {
    const numProductos = parseInt(document.getElementById('num_productos').value) || 0;
    const ProductFieldsContainer = document.getElementById('Productosadicionales');
    const currentProductFields = ProductFieldsContainer.childElementCount;

    if (numProductos === 0) {
        ProductFieldsContainer.innerHTML = '';
        productCount = 0;
        calcularTotalVenta();
        return;
    }

    if (numProductos > currentProductFields) {
        for (let i = currentProductFields; i < numProductos; i++) {
            addProductField();
        }
    } else if (numProductos < currentProductFields) {
        for (let i = currentProductFields; i > numProductos; i--) {
            ProductFieldsContainer.removeChild(ProductFieldsContainer.lastChild);
            productCount--;
        }
        document.getElementById('num_productos').value = productCount;
        calcularTotalVenta();
    }
}

function addProductField(data = null) {
    const ProductFieldsContainer = document.getElementById('Productosadicionales');
    const productDiv = document.createElement('div');
    productDiv.className = 'col-md-12 mb-2';

    const rowDiv = document.createElement('div');
    rowDiv.className = 'row';

    const divIdProducto = document.createElement('div');
    divIdProducto.className = 'col-md-3';

    const idProductoField = document.createElement('select');
    idProductoField.name = 'ProductosPorVenta[' + productCount + '][id_producto]';
    idProductoField.className = 'form-control mb-2';
    idProductoField.onchange = function() {
        updatePrecioUnitario(this);
    };

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

    divIdProducto.appendChild(idProductoField);

    const divCantidadVendida = document.createElement('div');
    divCantidadVendida.className = 'col-md-3';

    const cantidadVendidaField = document.createElement('input');
    cantidadVendidaField.type = 'number';
    cantidadVendidaField.name = 'ProductosPorVenta[' + productCount + '][cantidad_vendida]';
    cantidadVendidaField.className = 'form-control mb-2 cantidad-vendida-input';
    cantidadVendidaField.placeholder = 'Cantidad Vendida';
    cantidadVendidaField.oninput = function() {
        calcularMontoProducto(this);
    };

    divCantidadVendida.appendChild(cantidadVendidaField);

    const divPrecioUnitario = document.createElement('div');
    divPrecioUnitario.className = 'col-md-3';
    
    const precioUnitarioField = document.createElement('input');
    precioUnitarioField.type = 'hidden';
    precioUnitarioField.name = 'ProductosPorVenta[' + productCount + '][precio_unitario]';
    precioUnitarioField.className = 'form-control mb-2 precio-unitario-input';
    divPrecioUnitario.style.display = 'none';
    
    divPrecioUnitario.appendChild(precioUnitarioField);

    const divPrecioTotalProducto = document.createElement('div');
    divPrecioTotalProducto.className = 'col-md-3';

    const precioTotalProductoField = document.createElement('input');
    precioTotalProductoField.type = 'number';
    precioTotalProductoField.name = 'ProductosPorVenta[' + productCount + '][subtotal_producto]';
    precioTotalProductoField.className = 'form-control mb-2 precio-total-producto-input';
    precioTotalProductoField.placeholder = 'Precio total por producto';
    precioTotalProductoField.readOnly = true;

    divPrecioTotalProducto.appendChild(precioTotalProductoField);

    rowDiv.appendChild(divIdProducto);
    rowDiv.appendChild(divCantidadVendida);
    rowDiv.appendChild(divPrecioUnitario);
    rowDiv.appendChild(divPrecioTotalProducto);

    productDiv.appendChild(rowDiv);

    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn btn-danger';
    deleteButton.innerHTML = 'Eliminar Producto';
    deleteButton.onclick = function() {
        deleteProductField(productDiv);
    };
    productDiv.appendChild(deleteButton);

    ProductFieldsContainer.appendChild(productDiv);
    productCount++;

    // Populate fields if data is provided
    if (data) {
        idProductoField.value = data.id_producto;
        cantidadVendidaField.value = data.cantidad_vendida;
        precioUnitarioField.value = data.precio_unitario;
        precioTotalProductoField.value = data.subtotal_producto;
        calcularTotalVenta();
    }
}

function deleteProductField(productDiv) {
    productDiv.remove();
    productCount--;
    document.getElementById('num_productos').value = productCount;
    calcularTotalVenta();
}


    // Función para actualizar el precio unitario al cambiar el producto seleccionado
   
    function updatePrecioUnitario(element) {
    const selectedOption = element.value;
    const rowDiv = element.closest('.row');
    const cantidadVendidaField = rowDiv.querySelector('.cantidad-vendida-input');
    const precioUnitarioField = rowDiv.querySelector('.precio-unitario-input');

    console.log(`Fetching price for product ID: ${selectedOption}`);

    $.ajax({
        url: '<?= Url::to(['ventas/get-precio-unitario']) ?>',
        type: 'GET',
        data: { id: selectedOption },
        success: function(data) {
            console.log('Data from server: ', data);
            try {
                const response = JSON.parse(data);
                const precioUnitario = parseFloat(response.precio);
                console.log(`Received price: ${precioUnitario} for product ID: ${selectedOption}`);

                if (!isNaN(precioUnitario)) {
                    precioUnitarioField.value = precioUnitario;

                    const cantidadVendida = parseFloat(cantidadVendidaField.value);
                    if (!isNaN(cantidadVendida)) {
                        const precioTotal = precioUnitario * cantidadVendida;
                        const precioTotalField = rowDiv.querySelector('.precio-total-producto-input');
                        precioTotalField.value = precioTotal.toFixed(2);

                        console.log(`Updated total price: ${precioTotalField.value}`);
                        calcularTotalVenta();
                    }
                } else {
                    console.log(`Failed to retrieve price for product ID: ${selectedOption}`);
                }
            } catch (e) {
                console.error('Error parsing response: ', e);
            }
        }
    });
}


    // Función para calcular el monto total de cada producto (subtotal de producto)
    function calcularMontoProducto(element) {
        const rowDiv = element.closest('.row'); // Obtener el div de fila que contiene los campos
        const idProductoField = rowDiv.querySelector('select[name^="Ventas[productos]"]'); // Campo de id_producto
        const cantidadVendidaField = rowDiv.querySelector('.cantidad-vendida-input'); // Campo de cantidad vendida
        const precioTotalField = rowDiv.querySelector('.precio-total-producto-input'); // Campo de precio total del producto

        const selectedOption = idProductoField.value;
        console.log(`Selected option: ${selectedOption}`);

        if (selectedOption === '') {
            console.log('No product selected');
            return; // No product selected
        }

        // Fetch the price for the selected product
        $.ajax({
            url: '<?= Url::to(['ventas/get-precio-unitario']) ?>', // URL de la acción que obtiene el precio unitario
            type: 'GET',
            data: { id: selectedOption },
            success: function(data) {
                console.log('Data from server: ', data);
                const response = JSON.parse(data);
                const precioUnitario = parseFloat(response.precio);
                const cantidadVendida = parseFloat(cantidadVendidaField.value);

                console.log('Parsed precioUnitario:', precioUnitario);
                console.log('Parsed cantidadVendida:', cantidadVendida);

                if (!isNaN(precioUnitario) && !isNaN(cantidadVendida)) {
                    const precioTotal = precioUnitario * cantidadVendida;
                    console.log('Precio Total', precioTotal);
                    precioTotalField.value = precioTotal.toFixed(2);
                } else {
                    precioTotalField.value = 0;
                }

                // Recalcular el total de la venta
                console.log('Updating precioTotalField:', precioTotalField.value);

                // Function called to update total
                calcularTotalVenta();
            }
        });
    }

   
    
function calcularTotalVenta() {
    const cantidadInputs = document.querySelectorAll('.cantidad-vendida-input');
    const precioTotalInputs = document.querySelectorAll('.precio-total-producto-input');

    let totalVendida = 0;
    let totalVenta = 0;

    cantidadInputs.forEach(input => {
        totalVendida += parseFloat(input.value) || 0;
    });

    precioTotalInputs.forEach(input => {
        totalVenta += parseFloat(input.value) || 0;
    });

    document.getElementById('total_vendida').value = totalVendida;
    document.getElementById('total_venta').value = totalVenta.toFixed(2);
}

// Pre-populate product fields with existing data
existingProductData.forEach(data => {
    addProductField(data);
});

</script>