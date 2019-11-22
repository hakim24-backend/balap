<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Bracket */

$this->title = 'Create Bracket';
$this->params['breadcrumbs'][] = ['label' => 'Brackets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bracket-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
