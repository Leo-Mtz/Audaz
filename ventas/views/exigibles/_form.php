<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Exigibles */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(
    "$('#descarga').on('click', function(){
		$('#descarga').attr('disabled',true);
		$('#descarga').text('Descargando Exigibles');
		$('#descarga').append(\"&nbsp;&nbsp;<span class='spinner-border spinner-border-sm'></span>\");
		$.ajax({
			url: '".Url::to(['exigibles/descarga'])."',
			type: 'POST',
			dataType: 'json',
			success: function (data) {
				var registros = data.filas;
				var alertas = data.alertas;
				var correo = data.correo;
				$('#registros').html('Se insertaron: ' + registros + ' registros');
				$('#alertas').html(correo);
				$('#descarga').attr('disabled',false);
				$('#descarga').text('Descargar Exigibles');
			},
			error: function(jqXHR, errMsg) {
				if( errMsg == 'error' ){
					alert('OCURRIÓ UN ERROR AL DESCARGAR LA LISTA DE EXIGIBLES, INTENTAR NUEVAMENTE');
				}
				$('#descarga').attr('disabled',false);
			}
		 });
		return false;
	});",
    View::POS_READY,
    'exigibles'
);
?>

<div class="exigibles-form container">

    <?php //$form = ActiveForm::begin(); ?>
	
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="form-group">
					<button id="descarga" class="btn btn-primary">
						Descargar Exigibles
					</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md col-lg">
					<div id="registros"></div>
					<div id="alertas">
					</div>
				</div>
			</div>
		</div>
	</div>

    <?php //ActiveForm::end(); ?>

</div>
