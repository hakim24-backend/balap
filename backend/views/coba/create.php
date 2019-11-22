<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HeatOne */

$this->title = 'Create Heat One';
$this->params['breadcrumbs'][] = ['label' => 'Heat Ones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="heat-one-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
