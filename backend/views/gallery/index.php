<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Gallery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">

    <p>
        <?= Html::a('Create Gallery', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
            <?php Pjax::begin(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    [
                        'attribute' => 'filename',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'format' => 'raw',
                        'value' => function($model){
                            return '<img width="180" src="' . \Yii::$app->urlFrontend->baseUrl . '/img/gallery/' . $model->filename . '">';
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'view' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-eye-open"></span>']),['gallery/view','id'=>$model->id], ['class' => 'btn btn-warning modalButtonView']);
                            },
                            'update'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-pencil"></span>']), ['gallery/update','id'=>$model->id], ['class' => 'btn btn-info modalButtonUpdate']);
                            },
                            'delete'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-trash"></span>']), ['gallery/delete','id'=>$model->id], ['class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Apakah anda yakin untuk menghapus data ini ?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>  
        </div>
    </div>
</div>
