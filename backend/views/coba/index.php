<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HeatOneSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Heat Ones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="heat-one-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Heat One', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'POSISI',
            'NO_START',
            'NAMA',
            'TEAM',
            'KELAS',
            //'KENDARAAN',
            //'KOTA',
            //'RT',
            //'ET60',
            //'ET',
            //'SPEED',
            //'TIME',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
