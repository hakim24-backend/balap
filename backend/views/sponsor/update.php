<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sponsor */

$this->title = 'Update Sponsor';
$this->params['breadcrumbs'][] = ['label' => 'Sponsor', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sponsor-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
