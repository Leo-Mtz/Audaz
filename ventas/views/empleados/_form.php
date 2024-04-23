<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\CatEmpleados */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-empleados-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
		<div class="col-md col-lg">		
			<?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md col-lg">		
			<?= $form->field($model, 'paterno')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md col-lg">		
			<?= $form->field($model, 'materno')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md col-lg">		
			<?= $form->field($model, 'fecha_inicio')->widget(yii\jui\DatePicker::className(),['clientOptions' => ['showAnim'=>'fold','changeMonth'=> true,'changeYear'=> true],'options' => ['class' => 'form-control'],'language' => 'es-MX','dateFormat' => 'yyyy-MM-dd',]) ?>
		</div>
		
	</div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
