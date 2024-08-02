<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */
/* @var $form yii\widgets\ActiveForm */
/* @var $productosDropdown array */

$id_evento = Yii::$app->session->get('id_evento'); // Retrieve id_evento from session

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="ventas-form">


    <?php $form = ActiveForm::begin(); ?>

    <div class="row mt-3">
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
        <?= $form->field($model, 'tipo_de_venta')->dropDownList([
                'venta' => 'Venta',
                'degustacion' => 'Degustación',
                'cortesia' => 'Cortesía',
            ], ['prompt' => 'Seleccione tipo de venta', 
                'value'=>$model->tipo_de_venta]) ?>
    </div>

    <div class="col-md-4 col-lg-4">
        <?= $form->field($model, 'forma_de_pago')->dropDownList([
                'efectivo' => 'Efectivo',
                'tarjeta' => 'Tarjeta de Crédito/Débito',
                'transferencia' => 'Transferencia Bancaria',
                'value'=>$model->forma_de_pago
            ], ['prompt' => 'Seleccione una forma de pago', 'value'=>$model->forma_de_pago]) ?>
    </div>
</div>




    <div class="row mt-3">
        <div class="col-md-3 col-lg-2">
        <?= $form->field($model, 'productos_totales')->textInput([
            'placeholder' => 'Número de productos',
            'id' => 'num_productos',
            'oninput' => 'generateProductFields()'
        ]) ?>
    </div>

    
    <div class="col-md-6 col-lg-6">
      
    <?= $form->field($model, 'id_evento')->dropDownList(
            $eventosDropdown, 
            [ 'value' => $id_evento]
        ) ?>
        </div>
     </div>


    <div id="Productosadicionales" class="mt-3 row"></div>
    <button type="button" class="btn btn-primary" onclick="addProductField()">Agregar Producto</button>

  
    <div class="row mt-3">
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'cantidad_total_vendida')->textInput(['placeholder' => 'Total Vendida', 'id' => 'total_vendida', 'readonly' => true]) ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'precio_total_venta')->textInput(['placeholder' => 'Monto Total', 'id' => 'total_venta', 'readonly' => true]) ?>
        </div>
    

    </div>


    <?= $form->field($model, 'id_vendedor')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


     <script>
        function validateProductCount() {       
       const numProductos = parseInt(document.getElementById('num_productos').value) || 0;
        if (numProductos < 0) {
            document.getElementById('num_productos').value = 0;
            alert('El número de productos no puede ser negativo');
                    }
                }
        </script>

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
    const productosDropdown = <?= json_encode($productosDropdown) ?>;
    let productCount = 0;
    let selectedEventoId=null;

   
      /**
       * Generates product fields based on the value of the 'num_productos' input field.
       * If the value is zero, clears all existing fields and resets the product count.
       * If the value is greater than the current number of product fields, adds new fields.
       * If the value is less than the current number of product fields, removes excess fields.
       * Finally, updates the value of the 'num_productos' input field to match the current product count.
       */
      function generateProductFields() {
          // Get the value of the 'num_productos' input field and convert it to an integer
          const numProductos = parseInt(document.getElementById('num_productos').value) || 0;
      
          // Get the container element for the product fields
          const ProductFieldsContainer = document.getElementById('Productosadicionales');
      
          // Get the current number of product fields
          const currentProductFields = ProductFieldsContainer.childElementCount;
      
          // Clear existing fields if numProductos is zero
          if (numProductos === 0) {
              ProductFieldsContainer.innerHTML = ''; // Clear all fields
              productCount = 0; // Reset product count
              calcularTotalVenta(); // Recalculate total sale
              return;
          }
      
          // Add new product fields if numProductos is greater than currentProductFields
          if (numProductos > currentProductFields) {
              for (let i = currentProductFields; i < numProductos; i++) {
                  addProductField();
              }
          } 
          // Remove excess product fields if numProductos is less than currentProductFields
          else if (numProductos < currentProductFields) {
              for (let i = currentProductFields; i > numProductos; i--) {
                  ProductFieldsContainer.removeChild(ProductFieldsContainer.lastChild);
                  productCount--;
              }
              document.getElementById('num_productos').value = productCount;
              calcularTotalVenta();
          }
      }

//boton para añadir campos
    function addProductField() {
    const ProductFieldsContainer = document.getElementById('Productosadicionales');
    const productDiv = document.createElement('div');
    productDiv.className = 'col-md-12 mb-2';

    const rowDiv = document.createElement('div');
    rowDiv.className = 'row';

    const divIdProducto = document.createElement('div');
    divIdProducto.className = 'col-md-3';

    const idProductoField = document.createElement('select');
    idProductoField.name = 'Ventas[productos][' + productCount + '][id_producto]';
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
    cantidadVendidaField.name = 'Ventas[productos][' + productCount + '][cantidad_vendida]';
    cantidadVendidaField.className = 'form-control mb-2 cantidad-vendida-input';
    cantidadVendidaField.placeholder = 'Cantidad Vendida';
    cantidadVendidaField.oninput = function() {

        //valida que el input no sea negativo
        if(parseFloat(this.value) < 0){
            this.value = 0;
            alert('La cantidad vendida no puede ser negativa');
        }
        calcularMontoProducto(this);
    };

    divCantidadVendida.appendChild(cantidadVendidaField);

    const divPrecioUnitario = document.createElement('div');
    divPrecioUnitario.className = 'col-md-3';
    
    const precioUnitarioField = document.createElement('input');
    precioUnitarioField.type = 'hidden'; // Hidden field
    precioUnitarioField.name = 'Ventas[productos][' + productCount + '][precio_unitario]';
    precioUnitarioField.className = 'form-control mb-2 precio-unitario-input';
    
    // Set the style of the divPrecioUnitario to hide it
    divPrecioUnitario.style.display = 'none';
    
    divPrecioUnitario.appendChild(precioUnitarioField);

    const divPrecioTotalProducto = document.createElement('div');
    divPrecioTotalProducto.className = 'col-md-3';

    const precioTotalProductoField = document.createElement('input');
    precioTotalProductoField.type = 'number';
    precioTotalProductoField.name = 'Ventas[productos][' + productCount + '][subtotal_producto]';
    precioTotalProductoField.className = 'form-control mb-2 precio-total-producto-input';
    precioTotalProductoField.placeholder = 'Precio total por producto';
    precioTotalProductoField.readOnly = true;

    divPrecioTotalProducto.appendChild(precioTotalProductoField);

    rowDiv.appendChild(divIdProducto);
    rowDiv.appendChild(divCantidadVendida);
    rowDiv.appendChild(divPrecioUnitario); // Add hidden field to the row
    rowDiv.appendChild(divPrecioTotalProducto);

    const deleteButtonDiv = document.createElement('div');
    deleteButtonDiv.className = 'col-md-1 d-flex align-items-center justify-content-center';

    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn btn-danger btn-sm';

    const icon = document.createElement('i');
    icon.className = 'fas fa-times'; // Font Awesome 'X' icon class

    deleteButton.appendChild(icon);
    deleteButton.addEventListener('click', function() {
        deleteProductField(productDiv);
    });


    deleteButtonDiv.appendChild(deleteButton);
    rowDiv.appendChild(deleteButtonDiv);
    productDiv.appendChild(rowDiv);
  
    ProductFieldsContainer.appendChild(productDiv);

    productCount++;

    document.getElementById('num_productos').value = productCount;

    calcularTotalVenta();
}
    function deleteProductField(productDiv) {
        const ProductFieldsContainer = document.getElementById('Productosadicionales');
        ProductFieldsContainer.removeChild(productDiv);

        productCount--;

        if (ProductFieldsContainer.children.length === 0) {
            document.getElementById('num_productos').value = 0;
        } else {
            document.getElementById('num_productos').value = productCount;
        }

        calcularTotalVenta();
    }

    // Función para actualizar el precio unitario al cambiar el producto seleccionado
    function updatePrecioUnitario(element) {
    const selectedOption = element.value;
    const rowDiv = element.closest('.row'); // Get the row div containing the fields
    const cantidadVendidaField = rowDiv.querySelector('.cantidad-vendida-input'); // Quantity sold field
    const precioUnitarioField = rowDiv.querySelector('.precio-unitario-input'); // Hidden price unit field

    console.log(`Fetching price for product ID: ${selectedOption}`);

    // Make an AJAX request to get the unit price of the selected product
    $.ajax({
        url: '<?= Url::to(['ventas/get-precio-unitario']) ?>', // URL to action that gets unit price
        type: 'GET',
        data: { id: selectedOption },
        success: function(data) {
            console.log('Data from server: ', data);
            const response = JSON.parse(data);
            const precioUnitario = parseFloat(response.precio);
            console.log(`Received price: ${precioUnitario} for product ID: ${selectedOption}`);

            if (!isNaN(precioUnitario)) {
                // Set the unit price in the hidden field
                precioUnitarioField.value = precioUnitario;

                // Update the total price of the product
                const cantidadVendida = parseFloat(cantidadVendidaField.value);
                if (!isNaN(cantidadVendida)) {
                    const precioTotal = precioUnitario * cantidadVendida;
                    const precioTotalField = rowDiv.querySelector('.precio-total-producto-input');
                    precioTotalField.value = precioTotal.toFixed(2);

                    // Recalculate the total sale
                    calcularTotalVenta();
                }
            } else {
                console.log(`Failed to retrieve price for product ID: ${selectedOption}`);
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

    // Función para calcular el total de la venta sumando los precios totales de todos los productos
    function calcularTotalVenta() {
        let totalVenta = 0;
        let totalCantidadVendida = 0;

        // Iterar sobre todos los campos de precio total por producto y cantidad vendida para calcular el total de la venta
        document.querySelectorAll('.precio-total-producto-input').forEach(function(element) {
            const value = parseFloat(element.value);
            console.log("Precio Total: ", value);
            if (!isNaN(value)) {
                totalVenta += value;
                console.log('Total Venta: ', totalVenta);
            }
        });

        // Función para obtener el total de la cantidad vendida
        document.querySelectorAll('.cantidad-vendida-input').forEach(function(element) {
            // Obtiene la cantidad de cada producto 
            const cantidadVendida = parseFloat(element.value);
            if (!isNaN(cantidadVendida)) {
                totalCantidadVendida += cantidadVendida;
                console.log('Cantidad Vendida: ', cantidadVendida);
            }
        });

        // Mostrar el total de la cantidad vendida y el total de la venta en los campos correspondientes
        document.getElementById('total_vendida').value = totalCantidadVendida.toFixed(2);
        document.getElementById('total_venta').value = totalVenta.toFixed(2);

        const totalVentaField = document.getElementById('ventas-precio_total_venta');
        if (totalVentaField) {
            totalVentaField.value = totalVenta.toFixed(2);
        } else {
            console.log('El campo precio_total_venta no se encontró.');
        }
    }
</script>