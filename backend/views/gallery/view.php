<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */

$this->title = 'View Gallery';
$this->params['breadcrumbs'][] = ['label' => 'Galleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gallery-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'filename',
                            'contentOptions' => ['style'=>'text-align: center'],
                            'format' => 'raw',
                            'value' => function($model){
                                return '<img width="500" src="' . \Yii::$app->urlFrontend->baseUrl . '/img/gallery/' . $model->filename . '">';
                            }
                        ],
                    ],
                ]) ?>  
        </div>
    </div>
</div>
