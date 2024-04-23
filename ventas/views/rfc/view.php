<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rfc */

$this->title = "RFC - ".$model->rfc;
$this->params['breadcrumbs'][] = ['label' => 'RFC', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->rfc;
\yii\web\YiiAsset::register($this);
?>
<div class="rfc-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'rfc',
            'razon_social',
            [
                'attribute'=>'patente',
                'value'=>$model->patentes->patente,
            ],
            'agente_aduanal',
            'descripcion:ntext',
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
