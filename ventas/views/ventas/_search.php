<?php

use yii\helpers\Html;
use app\models\CatEventos;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\VentasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ventas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'], // Defines the action where the form will be submitted
        'method' => 'get', // Specifies that the form will use the GET method
    ]); ?>

    <!-- Field for searching by sale ID -->
    <?= $form->field($model, 'id_venta') ?>

    <!-- DatePicker widget for filtering by date -->
    <?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
        'clientOptions' => [
            'showAnim' => 'fold', // Animation for the date picker
            'changeMonth' => true, // Allow changing the month
            'changeYear' => true, // Allow changing the year
        ],
        'options' => [
            'class' => 'form-control', // CSS class for styling
            'id' => 'fecha-input', // ID for JavaScript or CSS targeting
        ],
        'language' => 'es-MX', // Language setting for the date picker
        'dateFormat' => 'yyyy-MM-dd', // Date format used in the input
    ]) ?>

    <!-- Field for searching by product ID -->
    <?= $form->field($model, 'id_producto') ?>

    <!-- Field for searching by quantity sold -->
    <?= $form->field($model, 'cantidad_vendida') ?>

    <!-- Field for searching by total sale price -->
    <?= $form->field($model, 'precio_total_venta') ?>

    <!-- Dropdown list for selecting an event, populated from CatEventos model -->
    <?= $form->field($model, 'id_evento')->dropDownList(
        ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento'), 
        ['prompt' => ''] // Prompt text to be displayed when no option is selected
    ) ?>

    <!-- Dropdown list for selecting payment method, populated with predefined options -->
    <?= $form->field($model, 'forma_de_pago' )->dropDownList($forma_de_pago, ['prompt'=>'']) ?>

    <!-- Dropdown list for selecting sale type, populated with predefined options -->
    <?= $form->field($model, 'tipo_de_venta')->dropDownList($tipo_de_venta, ['prompt'=>'']) ?>

    <div class="form-group">
        <!-- Submit button to perform the search -->
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        
        <!-- Reset button to clear the form fields -->
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
