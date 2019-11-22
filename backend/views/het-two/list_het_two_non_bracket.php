<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\HeatTwo;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HeatOneSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'HEAT 2 Kelas '.$kelas->NOMORKELAS.' Kategori '.$kelas->NAMAKELAS;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="heat-one-index">

    <p>
        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Remove Semua', ['all-remove','id' => $kelas->NOMORKELAS], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Export Excel', ['excel','id' => $kelas->NOMORKELAS], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-info">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [

                    // 'POSISI',
                    'NO_START',
                    'NAMA',
                    'TEAM',
                    // 'KELAS',
                    'KENDARAAN',
                    'KOTA',
                    'RT',
                    'ET60',
                    'ET',
                    //'SPEED',
                    'TIME',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{select}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'select' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-remove"></span>']),['het-two/remove-het','id'=>$model->ID], ['class' => 'btn btn-danger modalButtonView', 'title' => 'Remove Peserta']);
                            }
                        ],
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>  
        </div>
    </div>
</div>
