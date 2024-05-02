<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Entradas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entradas-form">

    <?php $form = ActiveForm::begin(); ?>

   <div class="row">
    <div class="col-md col-lg">		
			<?= $form->field($model, 'fecha')->widget(yii\jui\DatePicker::className(),['clientOptions' => ['showAnim'=>'fold','changeMonth'=> true,'changeYear'=> true],'options' => ['class' => 'form-control'],'language' => 'es-MX','dateFormat' => 'yyyy-MM-dd',]) ?>
		</div>

    <div class= "col-md col-lg">
        <?= $form->field($model, 'id_empleado')->dropdownList($empleados,['prompt' => 'Seleccionar empleado']) ?>
</div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'id_evento')->dropdownList($eventos,['prompt' => 'Seleccionar evento']) ?>
    </div>

    <div class="col-md col-lg">
         <?= $form->field($model, 'id_producto')->dropdownList($productos,['prompt' => 'Seleccionar producto']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'cantidad_entradas')->textInput() ?>
    </div>

</div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
