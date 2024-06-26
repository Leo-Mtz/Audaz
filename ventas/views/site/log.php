
<!--
This is a view file for the "log" action in the "site" controller.

The view file is responsible for rendering the login form. The form is built using the Yii2 framework's form builder.

The form has two fields: "username" and "password". The form is submitted to the "login" action in the "site" controller.

The form is wrapped in a "div" with the class "login-box" and "login-box-body". This is likely part of a larger design framework.

The form also includes a logo and a message at the top of the form.

The form is styled using Bootstrap 4.

The form also includes some JavaScript code to handle form validation.
-->
<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="login-box">
    <div class="login-box-body">
        <div class='login-logo'>
            <!--<div id="logo"><a href="#"><img src="#" class="img-responsive"></a></div>-->
        </div>
        <p class="login-box-msg">Ingresar usuario y contraseña</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'username', [
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

         

        <div class="row buttons pull-right">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
