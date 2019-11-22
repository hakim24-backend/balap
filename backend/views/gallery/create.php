<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */

$this->title = 'Create Gallery';
$this->params['breadcrumbs'][] = ['label' => 'Gallery', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
