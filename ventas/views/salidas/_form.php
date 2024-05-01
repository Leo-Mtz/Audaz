<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Salidas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salidas-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <div class="col-md col-lg">		
			<?= $form->field($model, 'fecha')->widget(yii\jui\DatePicker::className(),['clientOptions' => ['showAnim'=>'fold','changeMonth'=> true,'changeYear'=> true],'options' => ['class' => 'form-control'],'language' => 'es-MX','dateFormat' => 'yyyy-MM-dd',]) ?>
		</div>
	</div>

    <div class= "col-md col-lg">
        <?= $form->field($model, 'id_empleado')->dropdownList($empleados,['prompt' => 'Seleccionar empleado']) ?>
    </div>

    <div class="col-md col-lg">
        <?= $form->field($model, 'id_evento')->dropdownList($eventos,['prompt' => 'Seleccionar empleado']) ?>
    </div>

    <div class="col-md col-lg">
         <?= $form->field($model, 'id_producto')->dropdownList($productos,['prompt' => 'Seleccionar empleado']) ?>
    </div>
    
    <?= $form->field($model, 'cantidad_vendida')->textInput() ?>

    <?= $form->field($model, 'cantidad_degustacion')->textInput() ?>

    <?= $form->field($model, 'cantidad_cortesia')->textInput() ?>

    <?= $form->field($model, 'cantidad_total')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
