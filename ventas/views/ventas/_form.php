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
                'onchange' => 'fetchProductPrice(this.value)'
            ]) ?>
       
        </div>
    
        <div class="col-md-4">
    <?= $form->field($model, 'cantidad_vendida')->textInput(['class' => 'form-control quantity-input']) ?>
</div>
       <div class="col-md-4">
           <?= $form->field($model, 'precio_unitario')->textInput(['class' => 'form-control', 'readonly' => true, 'value' => $model->getPrecioUnitario($model->id_producto)]) ?>
       </div>
       
        <div class="col-md-4">
          
           <?= $form->field($model, 'precio_total_producto')->textInput(['readonly' => true]) ?>
   
        </div>
    </div>

    <div id="Productosadicionales" class="mt-3 row"></div>
    <button type="button" class="btn btn-primary" onclick="addProductField()">Agregar Producto</button>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_total_vendida')->textInput(['placeholder' => 'Total Vendida','readonly' => true]) ?>
    </div>


    <div class="col-md col-lg">
        <?= $form->field($model, 'precio_total_venta')->textInput() ?>
    </div>

    <?= $form->field($model, 'id_evento')->textInput() ?>
    <?= $form->field($model, 'id_vendedor')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<?php


$this->registerJs("
    function fetchProductPrice(productId) {
        if (productId) {
            $.ajax({
                url: '" . Url::to(['ventas/get-product-price']) . "?id=' + productId,
                type: 'GET',
                success: function(data) {
                    var response = data;
                    $('#ventas-precio_unitario').val(response.precio);
                    updatePrecioTotalProducto();
                }
            });
        } else {
            $('#ventas-precio_unitario').val('');
            updatePrecioTotalProducto();
        }
    }

    function updatePrecioTotalProducto() {
        var cantidadVendida = parseFloat($('#ventas-cantidad_vendida').val());
        var precioUnitario = parseFloat($('#ventas-precio_unitario').val());
        var precioTotalProducto = (cantidadVendida * precioUnitario).toFixed(2);
        $('#ventas-precio_total_producto').val(precioTotalProducto);
    }

    $('#ventas-cantidad_vendida').on('input', function() {
        updatePrecioTotalProducto();
    });

    function calcularTotalVendida() {
        var total_vendida = 0;
        $('.quantity-input').each(function() {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                total_vendida += value;
            }
        });
        $('#ventas-cantidad_total_vendida').val(total_vendida);
    }

    $(document).on('change', '.quantity-input', function() {
        calcularTotalVendida();
    });

    calcularTotalVendida(); // Initial calculation
");
?>



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

        // Create div for id_producto field with col-md-6 class
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

        // Create div for cantidad_vendida field with col-md-6 class
        const divCantidadVendida = document.createElement('div');
        divCantidadVendida.className = 'col-md-4';

        // Create a text input for cantidad_vendida
        const cantidadVendidaField = document.createElement('input');
        cantidadVendidaField.type = 'number';
        cantidadVendidaField.name = 'Ventas[productos][' + productCount + '][cantidad_vendida]'; // Set the name attribute for form submission
        cantidadVendidaField.className = 'form-control mb-2'; // Add a class for styling
        cantidadVendidaField.placeholder = 'Cantidad Vendida';

        // Append cantidad_vendida input to divCantidadVendida
        divCantidadVendida.appendChild(cantidadVendidaField);

        // Create div for precio_total_producto field with col-md-6 class
        const divPrecioTotalProducto = document.createElement('div');
        divPrecioTotalProducto.className = 'col-md-4';

        const PrecioTotalProducto = document.createElement('input');
        PrecioTotalProducto.type = 'number';
        PrecioTotalProducto.name = 'Ventas[productos][' + productCount + '][precio_total_producto]'; // Set the name attribute for form submission
        PrecioTotalProducto.className = 'form-control mb-2'; // Add a class for styling
        PrecioTotalProducto.placeholder = 'Precio total por producto';

        // Append divIdProducto and divCantidadVendida to rowDiv
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

