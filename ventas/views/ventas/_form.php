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
                'onchange' => 'updatePrecioUnitario(this)',
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cantidad_vendida')->textInput(['class' => 'form-control cantidad-vendida-input', 'id' => 'cantidad_vendida', 'oninput' => 'calcularMontoProducto(this)']) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'precio_unitario')->hiddenInput(['class' => 'form-control precio-unitario-input', 'id' => 'precio_unitario', 'readonly' => true, 'label'=>false]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'precio_total_producto')->textInput(['class'=>'precio-total-producto-input','id' => 'precio_total_producto', 'readonly' => true, 'oninput' => 'calcularTotalVenta()']) ?>
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
const productosDropdown = <?= json_encode($productosDropdown) ?>;
let productCount = 0;

function addProductField() {
    const ProductFieldsContainer = document.getElementById('Productosadicionales');

    const productDiv = document.createElement('div');
    productDiv.className = 'col-md-12 mb-2';

    const rowDiv = document.createElement('div');
    rowDiv.className = 'row';

    const divIdProducto = document.createElement('div');
    divIdProducto.className = 'col-md-4';

    const idProductoField = document.createElement('select');
    idProductoField.name = 'Ventas[productos][' + productCount + '][id_producto]';
    idProductoField.className = 'form-control mb-2';
    idProductoField.onchange = function() { updatePrecioUnitario(this); };

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
    divCantidadVendida.className = 'col-md-4';

    const cantidadVendidaField = document.createElement('input');
    cantidadVendidaField.type = 'number';
    cantidadVendidaField.name = 'Ventas[productos][' + productCount + '][cantidad_vendida]';
    cantidadVendidaField.className = 'form-control mb-2 cantidad-vendida-input';
    cantidadVendidaField.placeholder = 'Cantidad Vendida';
    cantidadVendidaField.oninput = function() { calcularMontoProducto(this); };

    divCantidadVendida.appendChild(cantidadVendidaField);

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

    productDiv.appendChild(rowDiv);

    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn btn-danger btn-sm';
    deleteButton.textContent = 'Eliminar Campo';
    deleteButton.addEventListener('click', function() {
        ProductFieldsContainer.removeChild(productDiv);
        calcularTotalVenta();
    });

    productDiv.appendChild(deleteButton);
    ProductFieldsContainer.appendChild(productDiv);

    productCount++;
}

function updatePrecioUnitario(element) {
    const selectedOption = element.value;
    const rowDiv = element.closest('.row');
    const precioUnitarioField = rowDiv.querySelector('.precio-unitario-input');
    const cantidadVendidaField = rowDiv.querySelector('.cantidad-vendida-input');
    const precioTotalProductoField = rowDiv.querySelector('.precio-total-producto-input');

    // Debugging
    console.log('updatePrecioUnitario called');
    console.log('Selected Option:', selectedOption);
    console.log('Row Div:', rowDiv);
    console.log('Precio Unitario Field:', precioUnitarioField);
    console.log('Cantidad Vendida Field:', cantidadVendidaField);
    console.log('Precio Total Producto Field:', precioTotalProductoField);

    $.ajax({
        url: '<?= Url::to(['ventas/get-precio-unitario']) ?>',
        data: { id: selectedOption },
        success: function(response) {
            const data = JSON.parse(response);
            precioUnitarioField.value = data.precio;
            calcularMontoProducto(cantidadVendidaField);
        },
        error: function() {
            precioUnitarioField.value = '';
            calcularMontoProducto(cantidadVendidaField);
        }
    });
}

function calcularMontoProducto(element) {
    const rowDiv = element.closest('.row');
    const precioUnitarioField = rowDiv.querySelector('.precio-unitario-input');
    const cantidadVendidaField = rowDiv.querySelector('.cantidad-vendida-input');
    const precioTotalProductoField = rowDiv.querySelector('.precio-total-producto-input');

    // Debugging
    console.log('calcularMontoProducto called');
    console.log('Row Div:', rowDiv);
    console.log('Precio Unitario Field:', precioUnitarioField);
    console.log('Cantidad Vendida Field:', cantidadVendidaField);
    console.log('Precio Total Producto Field:', precioTotalProductoField);

    const precio_unitario = parseFloat(precioUnitarioField ? precioUnitarioField.value : 0) || 0;
    const cantidad_vendida = parseFloat(cantidadVendidaField ? cantidadVendidaField.value : 0) || 0;
    const monto_producto = precio_unitario * cantidad_vendida;

    precioTotalProductoField.value = monto_producto.toFixed(2);
    calcularTotalVenta();
}

function calcularTotalVenta() {
    let totalVenta = 0;
    let totalCantidadVendida = 0;

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

    console.log('Total Venta:', totalVenta.toFixed(2));
    console.log('Total Cantidad Vendida:', totalCantidadVendida);

    document.getElementById('total_vendida').value = totalCantidadVendida;
    document.getElementById('precio_total_venta').value = totalVenta.toFixed(2);
}
</script>
