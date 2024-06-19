<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */
/* @var $form yii\widgets\ActiveForm */
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
            'id' => 'fecha-input', // Add an id attribute
        ],
        'language' => 'es-MX',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>
</div>

    

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'id_producto')->dropdownList($productosDropdown,['prompt' => 'Seleccionar producto']) ?>
    </div>
    
    <div class="col-md-6">
        <?= $form->field($model, 'cantidad_vendida')->textInput(['class' => 'form-control']) ?>
    </div>

    </div>

    <div id="Productosadicionales" class="mt-3 "></div>

    <button type="button" class="btn btn-primary" onclick="addProductField()">Agregar Campo Simple</button>


    <div class="col-md col-lg">
    <?= $form->field($model, 'precio_total')->textInput() ?>
    </div>

    <?= $form->field($model, 'id_evento')->textInput() ?>

    <?= $form->field($model, 'id_vendedor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




<script>
    let productCount = 0; // Initialize productCount

    function addProductField() {
        const ProductFieldsContainer = document.getElementById('Productosadicionales');

        // Create a text input for id_producto
        const idProductoField = document.createElement('input');
        idProductoField.type = 'number';
        idProductoField.name = 'Ventas[productos][' + productCount + '][id_producto]'; // Set the name attribute for form submission
        idProductoField.className = 'form-control mb-2'; // Add a class for styling
        idProductoField.placeholder = 'Id Producto';

        // Create a text input for cantidad_vendida
        const cantidadVendidaField = document.createElement('input');
        cantidadVendidaField.type = 'number';
        cantidadVendidaField.name = 'Ventas[productos][' + productCount + '][cantidad_vendida]'; // Set the name attribute for form submission
        cantidadVendidaField.className = 'form-control mb-2'; // Add a class for styling
        cantidadVendidaField.placeholder = 'Cantidad Vendida';

        ProductFieldsContainer.appendChild(idProductoField);
        ProductFieldsContainer.appendChild(cantidadVendidaField);

        productCount++; // Increment productCount for the next field
    }
</script>