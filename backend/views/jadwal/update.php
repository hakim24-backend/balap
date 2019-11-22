<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Jadwal */

$this->title = 'Update Jadwal';
$this->params['breadcrumbs'][] = ['label' => 'Jadwals', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jadwal-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
