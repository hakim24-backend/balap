<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SetKelas */

$this->title = 'Create Set Kelas';
$this->params['breadcrumbs'][] = ['label' => 'Set Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-kelas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
