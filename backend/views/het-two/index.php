<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SetKelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'HEAT 2 Per Kelas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-kelas-index">
    <div class="box box-info">
        <div class="box-body">
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
                        'template' => '{list}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'list' => function($url, $model, $key){
                                return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-list"></span>']),['het-two/list-het-two','id'=>$model->NOMORKELAS], ['class' => 'btn btn-primary modalButtonView', 'title' => 'List Peserta']);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
