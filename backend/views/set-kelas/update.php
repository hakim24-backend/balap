<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SetKelas */

$this->title = 'Update Set Kelas';
$this->params['breadcrumbs'][] = ['label' => 'Set Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="set-kelas-update">

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
        'dataKategori' => $dataKategori
    ]) ?>

</div>
