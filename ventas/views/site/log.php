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

use yii\helpers\Url;

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
            ->textInput(['placeholder' => 'Usuario', 'onchange' => 'fetchEventos()']) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => 'Contraseña']) ?>

        <!-- Eventos Dropdown Container -->
        <div class="row form-group has-feedback" id="eventosDropdownContainer" style="display: none;">
            <div id="eventosDropdown"></div>
        </div>
 
        <div class="row buttons pull-right">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    function fetchEventos() {
        var username = $('#loginform-username').val();
        console.log("Fetching eventos for username:", username); // Debug: Log the username

        var data = {
            'username': username
        };

        $.ajax({
            type: 'POST',
            url: '<?= Url::to(['site/get-eventos']) ?>',
            data: data,
            success: function(response) {
                console.log("Received response:", response); // Debug: Log the response

                if (response.success) {
                    $('#eventosDropdown').html(response.dropdown);
                    $('#eventosDropdownContainer').show();
                } else {
                    console.log("Error:", response.message); // Debug: Log any error message
                    $('#eventosDropdownContainer').hide();
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX error:", status, error); // Debug: Log AJAX errors
                console.log("Response text:", xhr.responseText); // Debug: Log the response text from server
            }
        });
    }
</script>
