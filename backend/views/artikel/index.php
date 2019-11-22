<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ArtikelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Artikel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikel-index">
    <p>
        <?= Html::a('Create Artikel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'options' =>[
                  'style'=>'width:100%'
                ],
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    'judul',
                    [
                        'attribute' => 'konten',
                        'headerOptions' =>[
                        'style' => 'width:50%'
                        ],
                        'format' => 'raw',
                        'value' => function($m)
                        {
                            return substr($m->konten,0,200);
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{pdf} {view} {update} {delete}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'pdf' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-file"></span>']),['artikel/list-pdf','id'=>$model->id], ['class' => 'btn btn-success modalButtonView']);
                            },
                            'view' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-eye-open"></span>']),['artikel/view','id'=>$model->id], ['class' => 'btn btn-warning modalButtonView']);
                            },
                            'update'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-pencil"></span>']), ['artikel/update','id'=>$model->id], ['class' => 'btn btn-info modalButtonUpdate']);
                            },
                            'delete'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-trash"></span>']), ['artikel/delete','id'=>$model->id], ['class' => 'btn btn-danger',
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
        </div>
    </div>
</div>
