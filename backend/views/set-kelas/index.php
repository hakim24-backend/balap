<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SetKelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Set Kategori Per Kelas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-kelas-index">
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

                    [
                        'attribute' => 'NOMORKELAS',
                        'label' => 'Kelas',
                        'headerOptions' =>[
                        'style' => 'width:10%'
                        ],
                    ],
                    [
                        'attribute' => 'NAMAKELAS',
                        'contentOptions' => ['style'=>'text-align: center'],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {remove}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'update' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-pencil"></span>']),['set-kelas/update-kelas','id'=>$model->NOMORKELAS], ['class' => 'btn btn-success modalButtonView', 'title' => 'Update Kelas']);
                            },
                            'remove' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-remove"></span>']),['set-kelas/remove-kelas','id'=>$model->NOMORKELAS], ['class' => 'btn btn-danger modalButtonView', 'title' => 'Remove Kelas']);
                            }
                        ],
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>  
        </div>
    </div>
</div>
