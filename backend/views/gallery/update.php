<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */

$this->title = 'Update Gallery';
$this->params['breadcrumbs'][] = ['label' => 'Gallery', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gallery-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
