<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\SetKelas;
/* @var $this yii\web\View */
/* @var $searchModel common\models\KelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kelas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kelas-index">
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
                        'template' => '{pdf}',
                        'contentOptions' => ['style'=>'text-align: center'],
                        'buttons' => [
                            'pdf' => function($url, $model, $key){

                                $cekKelas = SetKelas::find()->where(['NAMAKELAS' => $model->NAMAKELAS])->one();

                                if ($cekKelas == null) {
                                    return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-check"></span>']),['kelas/set-kelas','id'=>$model->NOMORKELAS], ['class' => 'btn btn-success modalButtonView', 'title' => 'Set Kelas']);
                                } else {
                                    return Html::a(Yii::t('app','{modelClass}',['modelClass'=>'<span class="glyphicon glyphicon-remove"></span>']),['kelas/remove-kelas','id'=>$model->NOMORKELAS], ['class' => 'btn btn-danger modalButtonView', 'title' => 'Remove Kelas']);
                                }

                            }
                        ],
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>  
        </div>
    </div>
</div>
