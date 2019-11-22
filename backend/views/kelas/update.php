<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Kelas */

$this->title = 'Update Kelas: ' . $model->NOMORKELAS;
$this->params['breadcrumbs'][] = ['label' => 'Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NOMORKELAS, 'url' => ['view', 'id' => $model->NOMORKELAS]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kelas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
