<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\JadwalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Jadwal';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-index">

    <p>
        <?= Html::a('Create Jadwal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

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

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {update} {delete}',
                            'contentOptions' => ['style'=>'text-align: center'],
                            'buttons' => [
                                'view' => function($url, $model, $key){
                                    return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-eye-open"></span>']),['jadwal/view','id'=>$model->id], ['class' => 'btn btn-warning modalButtonView']);
                                },
                                'update'=> function($url, $model, $key){
                                    return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-pencil"></span>']), ['jadwal/update','id'=>$model->id], ['class' => 'btn btn-info modalButtonUpdate']);
                                },
                                'delete'=> function($url, $model, $key){
                                    return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-trash"></span>']), ['jadwal/delete','id'=>$model->id], ['class' => 'btn btn-danger',
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
</div>
