<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatSabores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-sabores-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
		<div class="col-md col-lg">		
			<?= $form->field($model, 'sabor')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md col-lg">
		</div>
	</div>
	
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
