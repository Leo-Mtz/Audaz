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

<<<<<<< HEAD
        <?php $form = ActiveForm::begin(['id' => 'login-form2']) ?>
=======
        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>
>>>>>>> main

        <?= $form->field($model, 'id_evento')->dropDownList($model->eventos, ['prompt' => 'Seleccione Evento']) ?>

        <div class="row buttons pull-right">
            <?= Html::submitButton('Continuar', ['class' => 'btn btn-primary btn-block']) ?>
<<<<<<< HEAD
            <?= Html::a('Regresar', ['site/index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
=======
        </div>

        <?php ActiveForm::end(); ?>
>>>>>>> main
    </div>
</div>
