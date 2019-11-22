<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SetKelas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="set-kelas-form">
	<div class="box box-info">
		<div class="box-body">
			<?php $form = ActiveForm::begin(); ?>

		    <?php 
            echo Select2::widget([
                'name' => 'kategori',
                'data' => $data,
                'value' => $dataKategori,
                'options' => [
                    'placeholder' => 'Pilih Kategori...', 
                    'id'=>'kategori',
                    'required'=>true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'initialize' => true,
                ],
            ])
          ?><br>

		    <div class="form-group">
		        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-danger']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>	
		</div>
	</div>
</div>
