<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'File Artikel '.$model->judul;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikel-file-index">

    <p>
        <?= Html::a('Create Artikel File', ['create-file','id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-danger']) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    'filename',
                    // 'id_artikel',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{download} {delete}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'download' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-download-alt"></span>']),['artikel/download','id'=>$model->id], ['class' => 'btn btn-success modalButtonView']);
                            },
                            'delete'=> function($url, $model, $key){
                                return  Html::a(Yii::t('app', ' {modelClass}', ['modelClass' => '<span class="glyphicon glyphicon-trash"></span>']), ['artikel/delete-file','id'=>$model->id], ['class' => 'btn btn-danger',
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