<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HeatOne */

$this->title = 'Update Heat One: ' . $model->POSISI;
$this->params['breadcrumbs'][] = ['label' => 'Heat Ones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->POSISI, 'url' => ['view', 'id' => $model->POSISI]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="heat-one-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
