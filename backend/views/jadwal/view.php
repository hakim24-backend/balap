<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Jadwal */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Jadwals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jadwal-view">

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
                    // 'id',
                    'name',
                    'location',
                    [
                        'attribute' => 'date',
                        'value' => function($model){
                            return date_format(date_create($model->date), 'd F Y');
                        }
                    ],
                    [
                        'attribute' => 'time',
                        'value' => function($model){
                            return date('g:i A', strtotime($model->time));
                        }
                    ],
                ],
            ]) ?>  
        </div>
    </div>
</div>
