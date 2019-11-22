<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HeatOne */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="heat-one-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POSISI')->textInput() ?>

    <?= $form->field($model, 'NO_START')->textInput() ?>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEAM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KELAS')->textInput() ?>

    <?= $form->field($model, 'KENDARAAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KOTA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RT')->textInput() ?>

    <?= $form->field($model, 'ET60')->textInput() ?>

    <?= $form->field($model, 'ET')->textInput() ?>

    <?= $form->field($model, 'SPEED')->textInput() ?>

    <?= $form->field($model, 'TIME')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
