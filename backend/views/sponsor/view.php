<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sponsor */

$this->title = 'View Sponsor';
$this->params['breadcrumbs'][] = ['label' => 'Sponsor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sponsor-view">

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
                        'attribute' => 'type',
                        'format' => 'raw',
                        'value' => function($model){
                            if ($model->type == 1) {
                                return '<span class="label label-success">WEB</span>';
                            } else {
                                return '<span class="label label-primary">MOBILE</span>';
                            }
                        }
                    ],
                    [
                        'attribute' => 'filename',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'format' => 'raw',
                        'value' => function($model){
                            return '<img width="500" src="' . \Yii::$app->urlFrontend->baseUrl . '/img/sponsor/' . $model->filename . '">';
                        }
                    ],
                ],
            ]) ?>  
        </div>
    </div>
</div>
