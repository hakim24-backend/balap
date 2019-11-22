<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Artikel */

$this->title = 'Create Artikel';
$this->params['breadcrumbs'][] = ['label' => 'Artikel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikel-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
