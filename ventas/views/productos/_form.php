<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatProductos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-productos-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
		<div class="col-md col-lg">		
			<?= $form->field($model, 'id_sabor')->dropdownList($sabores,['prompt' => 'Seleccionar sabor...']) ?>	
		</div>
		<div class="col-md col-lg">
			<?= $form->field($model, 'id_presentacion')->dropdownList($presentaciones,['prompt' => 'Seleccionar presentación...']) ?>	
		</div>
		<div class="col-md col-lg">
			<?= $form->field($model, 'precio')->textInput() ?>
		</div>


</div>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
