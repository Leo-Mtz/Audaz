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
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_venta')->textInput(['class' => 'column-id-venta']) ?>

    <?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
        'clientOptions' => [
            'showAnim' => 'fold',
            'changeMonth' => true,
            'changeYear' => true,
        ],
        'options' => [
            'class' => 'form-control column-fecha',
            'id' => 'fecha-input',
        ],
        'language' => 'es-MX',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'id_producto')->textInput(['class' => 'column-id-producto']) ?>

    <?= $form->field($model, 'cantidad_vendida')->textInput(['class' => 'column-cantidad-vendida']) ?>

    <?= $form->field($model, 'precio_total_venta')->textInput(['class' => 'column-precio-total-venta']) ?>

    <?= $form->field($model, 'id_evento')->dropDownList(
        ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento'),
        ['prompt' => '', 'class' => 'column-id-evento']
    ) ?>

    <?= $form->field($model, 'forma_de_pago')->dropDownList($forma_de_pago, ['prompt' => '', 'class' => 'column-forma-de-pago']) ?>

    <?= $form->field($model, 'tipo_de_venta')->dropDownList($tipo_de_venta, ['prompt' => '', 'class' => 'column-tipo-de-venta']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
