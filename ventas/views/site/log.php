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
        
        <div id="eventosDropdownContainer" style="display: none;">
            <div id="eventosDropdown">
            <?= $form->field($model, 'id_evento')->dropDownList([], ['id' => 'eventosDropdown']) ?>
            </div>
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
        'username': username,
        '_csrf': '<?= Yii::$app->request->csrfToken ?>' // Ensure CSRF token is included
    };

    console.log("Data:", data); // Debug: Log the data

    $.ajax({
        type: 'POST',
        url: '<?= yii\helpers\Url::to(['site/get-eventos']) ?>',
        data: data,
        success: function(response) {
            console.log("Received response:", response); // Debug: Log the response

            if (response.success) {
                $('#eventosDropdown').html(response.dropdown);
                $('#eventosDropdownContainer').show();

                // Add change event listener to the new dropdown
                $('#eventosDropdown select').on('change', function() {
                    const selectedEventoId = $(this).val();
                    console.log("Selected evento ID:", selectedEventoId); // Log the selected evento ID
                });

            } else {
                console.log("Couldn't quite do it"); // Debug: Log any error message
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
