<?php

use yii\helpers\Html;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
$basePath = Yii::getAlias('@frontend/');
?>

<div class="gallery-form">
	<div class="box box-info">
		<div class="box-body">
			<?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data']
            ]); ?>

			<?php if ($model->filename == null) { ?>
				<?= $form->field($model, 'filename')->widget(FileInput::classname(), [
			        'options' => [
			            'accept' => 'image/*',
			            'required'=>true,
			        ],
			        'pluginOptions' => [
			            // 'showPreview' => false,
			            // 'showCaption' => true,
			            // 'showRemove' => true,
			            'removeClass' => 'btn btn-danger',
			            'showUpload' => false,
			            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i>'
			        ],
			    ])->label('Foto') ?>
			<?php } else { ?>
				<?php
                    echo '<label>Foto</label>';
                    echo FileInput::widget([
                        'model' => $model,
                        'attribute' => 'filename',
                        'options'=>[
                            'accept' => 'image/*'
                        ],
                        'pluginOptions' => [
                            'initialPreview'=>[
                                Html::img(Yii::$app->urlFrontend->baseUrl . '/img/gallery/' . $model->filename, ['style' => 'width:150px;height:auto']),
                            ],
                            'removeClass' => 'btn btn-danger',
                            'showUpload' => false,
                            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i>',
                            'overwriteInitial'=>false,
                        ]
                    ]);
                ?><br>
			<?php } ?>	
		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
