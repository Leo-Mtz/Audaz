
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

<<<<<<< HEAD
         
=======
        <?php if ($model->privilegio == 2): ?>
            <?= $form->field($model, 'id_evento')->dropDownList([], ['prompt' => 'Seleccione Evento']) ?>
        <?php endif; ?>

>>>>>>> main

        <div class="row buttons pull-right">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<<<<<<< HEAD
=======

<?php
$script = <<< JS
$(document).ready(function(){
    $('form#login-form').on('beforeSubmit', function(e){
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function(response){
                if (response.success) {
                    // Check if the user has privilege 2 and update eventos dropdown
                    if (response.privilegio == 2 && response.eventos.length > 0) {
                        var dropdown = $('#loginform-id_evento');
                        dropdown.empty();
                        $.each(response.eventos, function(key, value) {
                            dropdown.append($('<option></option>').attr('value', key).text(value));
                        });
                        dropdown.prop('disabled', false); // Enable the dropdown
                    } else {
                        $('#loginform-id_evento').empty().append($('<option></option>').attr('value', '').text('Seleccione Evento'));
                    }
                }
            }
        });
        return false;
    });
});
JS;
$this->registerJs($script);
?>
>>>>>>> main
