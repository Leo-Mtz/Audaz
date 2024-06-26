<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatPresentaciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-presentaciones-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
		<div class="col-md col-lg">		
			<?= $form->field($model, 'presentacion')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md col-lg">
		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
