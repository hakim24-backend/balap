<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HeatOneSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="heat-one-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'POSISI') ?>

    <?= $form->field($model, 'NO_START') ?>

    <?= $form->field($model, 'NAMA') ?>

    <?= $form->field($model, 'TEAM') ?>

    <?= $form->field($model, 'KELAS') ?>

    <?php // echo $form->field($model, 'KENDARAAN') ?>

    <?php // echo $form->field($model, 'KOTA') ?>

    <?php // echo $form->field($model, 'RT') ?>

    <?php // echo $form->field($model, 'ET60') ?>

    <?php // echo $form->field($model, 'ET') ?>

    <?php // echo $form->field($model, 'SPEED') ?>

    <?php // echo $form->field($model, 'TIME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
