<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sponsor */

$this->title = 'Create Sponsor';
$this->params['breadcrumbs'][] = ['label' => 'Sponsor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sponsor-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
