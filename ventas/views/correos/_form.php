<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CorreosAlerta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="correos-alerta-form container">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->errorSummary($model,['class' => 'errors']) ?>
	
	<div class="card">
		<div class="card-body">
			<div class="card-header"></div>
			<div class="row">
				<div class="col-md col-lg">
					<?= $form->field($model, 'correo')->input('email') ?>
				</div>
			</div>

			<div class="form-group">
				<?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
