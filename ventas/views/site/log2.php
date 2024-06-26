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
        <p class="login-box-msg">Seleccionar evento</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'id_evento')->dropDownList($model->eventos, ['prompt' => 'Seleccione Evento']) ?>

        <div class="row buttons pull-right">
            <?= Html::submitButton('Continuar', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
