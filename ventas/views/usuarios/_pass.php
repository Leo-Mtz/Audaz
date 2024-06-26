<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->registerJs(
    "$('#usuarios-privilegio').on('change', function(){
	});",
    View::POS_READY,
    'privilegio'
);

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form container">
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->errorSummary($model,['class' => 'errors']) ?>
	
	<div class="card">
		<div class="card-body">
			<div class="card-header"></div>
			<div class="row">
				<div class="col-md col-lg">	
					<?= $form->field($model, '_passAnterior')->passwordInput() ?>				
					<?//= Html::tag('label', 'Contraseña Anterior',['class' => 'control-label','for' => 'passAnterior']); ?>
					<?//= Html::input('text', 'passAnterior', '', ['class' => 'form-control','id' => 'passAnterior']) ?>
				</div>
				
				<div class="col-md col-lg">				
					<?= $form->field($model, '_passNuevo')->passwordInput() ?>		
				</div>

				<div class="col-md col-lg">				
					<?= $form->field($model, '_passConfirmarNuevo')->passwordInput() ?>	
				</div>
			</div>
			<br/>
			<div class='col-md col-lg'>
				<div class="form-group">
					<p>La contrase&ntilde;a deber cumplir con lo siguiente:</p>
					<ul>
						<li>Al menos 8 caracteres</li>
						<li>Al menos una letra may&uacute;scula</li>
						<li>Al menos una letra min&uacute;scula</li>
						<li>Al menos un n&uacute;mero</li>
						<li>Al menos un caracter especial. Ej: #$%^&*()+=-[]';,.\/{}|":<>?~</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary']) ?>
	</div>
    <?php ActiveForm::end(); ?>
</div>
