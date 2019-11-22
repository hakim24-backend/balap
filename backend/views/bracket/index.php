<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BracketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Bracket';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bracket-index">

    <p>
        <?= Html::a('Create Bracket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    'nama_bracket',
                    'batas_atas',
                    'batas_bawah',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'view' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-eye-open"></span>']),['bracket/view','id'=>$model->id], ['class' => 'btn btn-warning modalButtonView']);
                            },
                            'update'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-pencil"></span>']), ['bracket/update','id'=>$model->id], ['class' => 'btn btn-info modalButtonUpdate']);
                            },
                            'delete'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-trash"></span>']), ['bracket/delete','id'=>$model->id], ['class' => 'btn btn-danger',
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
