<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PasswordResetRequestForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Request Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out your email. A link to reset password will be sent there.</p>

    <?php $form = ActiveForm::begin([
        'id' => 'request-password-reset-form',
        'options' => ['class' => 'form-horizontal'],
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'request-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
