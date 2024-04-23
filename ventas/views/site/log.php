<?php
use yii\helpers\Html;
?>
<div class="login-box">
	<div class="login-box-body">
		<div class='login-logo'>
			<!--<div id="logo"><a href="#"><img src="#" class="img-responsive"></a></div>-->
		</div>
		<p class="login-box-msg">Ingresar usuario y contraseña</p>

		<?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

		<?= $form->field($model,'username', [
			'options' => ['class' => 'form-group has-feedback'],
			'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>',
			'template' => '{beginWrapper}{input}{error}{endWrapper}',
			'wrapperOptions' => ['class' => 'input-group mb-3']
		])
			->label(false)
			->textInput(['placeholder' => 'Usuario']) ?>

		<?= $form->field($model, 'password', [
			'options' => ['class' => 'form-group has-feedback'],
			'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
			'template' => '{beginWrapper}{input}{error}{endWrapper}',
			'wrapperOptions' => ['class' => 'input-group mb-3']
		])
			->label(false)
			->passwordInput(['placeholder' => 'Contraseña']) ?>
			
		<div class="clear"></div>
		
		<div class="row buttons pull-right">
			<?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block']) ?>
		</div>

		<?php \yii\bootstrap4\ActiveForm::end(); ?>
	</div>
</div>