<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SponsorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Sponsor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sponsor-index">

    <p>
        <?= Html::a('Create Sponsor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' =>[
                  'style'=>'width:100%'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    [
                        'attribute' => 'filename',
                        'headerOptions' =>[
                            'style' => 'width:50%'
                            ],
                        'contentOptions' => ['style'=>'text-align: center'],
                        'format' => 'raw',
                        'value' => function($model){
                            return '<img width="180" src="' . \Yii::$app->urlFrontend->baseUrl . '/img/sponsor/' . $model->filename . '">';
                        }
                    ],
                    [
                        'attribute' => 'type',
                        'filter' =>[1 => 'WEB', 2 => 'MOBILE'],
                        'contentOptions' => ['style'=>'text-align: center'],
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
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'view' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-eye-open"></span>']),['sponsor/view','id'=>$model->id], ['class' => 'btn btn-warning modalButtonView']);
                            },
                            'update'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-pencil"></span>']), ['sponsor/update','id'=>$model->id], ['class' => 'btn btn-info modalButtonUpdate']);
                            },
                            'delete'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-trash"></span>']), ['sponsor/delete','id'=>$model->id], ['class' => 'btn btn-danger',
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
