<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rfc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rfc-form container">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->errorSummary($model,['class' => 'errors']) ?>
	
	<div class="card">
		<div class="card-body">
			<div class="card-header"></div>
				<div class="row">
					<div class="col-md col-lg">
						<?= $form->field($model, 'rfc')->textInput(['maxlength' => true,'style' => 'text-transform:uppercase']) ?>
					</div>
					<div class="col-md col-lg">
						<?= $form->field($model, 'razon_social')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md col-lg">
						<?= $form->field($model, 'patente')->dropdownList($items,['prompt' => 'Seleccionar patente...']) ?>
					</div>
					<div class="col-md col-lg">
						<?= $form->field($model, 'agente_aduanal')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md col-lg">
						<?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
					</div>
				</div>
			<div class="form-group">
				<?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
