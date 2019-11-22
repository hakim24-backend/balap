<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\Artikel */

$this->title = 'Create Artikel PDF';
$this->params['breadcrumbs'][] = ['label' => 'Artikel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikel-create">
	<div class="box box-info">
		<div class="box-body">
			<?php $form = ActiveForm::begin([
				'options' => ['enctype' => 'multipart/form-data']
			]); ?>

			<?= $form->field($model, 'filename[]')->widget(FileInput::classname(), [
		        'options' => [
		        	'multiple' => true,
		            'accept' => 'application/pdf',
		            'required' => true
		        ],
		        'pluginOptions' => [
		            // 'showPreview' => false,
		            // 'showCaption' => true,
		            // 'showRemove' => true,
		            'removeClass' => 'btn btn-danger',
		            'showUpload' => false,
		            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i>'
		        ],
		    ])->label('File') ?>

		    <div class="form-group">
		        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
		        <?= Html::a('Kembali', ['list-pdf','id'=>$id], ['class' => 'btn btn-danger']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>	
		</div>
	</div>
</div>
