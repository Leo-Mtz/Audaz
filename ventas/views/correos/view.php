<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CorreosAlerta */

$this->title = $model->correo;
$this->params['breadcrumbs'][] = ['label' => 'Correos Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="correos-alerta-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'correo',
			[
                'attribute'=>'borrado',
                'value'=>($model->borrado === '0' ? 'ACTIVO' : 'BORRADO' ),
            ],
        ],
    ]) ?>
	
	<p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php if( $model->borrado === '0' ){?>
			<?= Html::a('Borrar', ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => '¿Seguro que desea eliminar este registro?',
					'method' => 'post',
				],
			]) ?>
		<?php }?>
    </p>

</div>
