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
					<?= $form->field($model, 'username')->input('email')?>
				</div>
				<!--<div class="col-md col-lg">			
					<?//= $form->field($model, 'password')->passwordInput() ?>
				</div>-->
				<div class="col-md col-lg">			
					<?//= $form->field($model, 'privilegio')->dropDownList([1=>'Administrador',2=>'Otro',2=>'Otro'],['prompt'=>'Seleccionar privilegio...']) ?>
					<?= $form->field($model, 'privilegio')->dropDownList([1=>'Administrador'],['prompt'=>'Seleccionar privilegio...']) ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md col-lg">				
					<?//= Html::checkboxList('roles', [16, 42], ArrayHelper::map($roleModels, 'id', 'name')) ?>
				</div>
			</div>
			
			<div class="form-group">
				<?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
    <?php ActiveForm::end(); ?>
</div>
