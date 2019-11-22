<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Artikel */

$this->title = 'View Artikel';
$this->params['breadcrumbs'][] = ['label' => 'Artikels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="artikel-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'id',
                    'judul',
                    [
                        'attribute' => 'konten',
                        'format' => 'raw',
                        'value' => function($d){
                            return $d->konten;
                        }
                    ],
                    [
                        'attribute' => 'datetime_created',
                        'value' => function($model){
                            if ($model->datetime_created == null) {
                                return 'Belum Ada';
                            } else {
                                return $model->datetime_created;
                            }
                        }
                    ],
                    [
                        'attribute' => 'gambar',
                        'format' => 'raw',
                        'value' => function ($data) {
                           return  '<img class="img-responsive" width="180" src="' . \Yii::$app->urlFrontend->baseUrl . '/img/artikel/' . $data->gambar . '">';
                
                        }
                    ],
                ],
            ]) ?>  
        </div>
    </div>
</div>
