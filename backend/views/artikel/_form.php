<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\Artikel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="artikel-form">
	<div class="box box-info">
		<div class="box-body">
			<?php $form = ActiveForm::begin([
				'options' => ['enctype' => 'multipart/form-data']
			]); ?>

		    <?= $form->field($model, 'judul')->textInput(['maxlength' => true, 'required'=>true]) ?>

		    <?php if ($model->gambar == null) { ?>
				<?= $form->field($model, 'file[]')->widget(FileInput::classname(), [
			        'options' => [
			        	'multiple' => true,
			            'accept' => 'application/pdf',
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
			<?php } ?>

		    <?php if ($model->gambar == null) { ?>
				<?= $form->field($model, 'gambar')->widget(FileInput::classname(), [
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
                        'attribute' => 'gambar',
                        'options'=>[
                            'accept' => 'image/*'
                        ],
                        'pluginOptions' => [
                            'initialPreview'=>[
                                Html::img(Yii::$app->urlFrontend->baseUrl . '/img/artikel/' . $model->gambar, ['style' => 'width:150px;height:auto']),
                            ],
                            'removeClass' => 'btn btn-danger',
                            'showUpload' => false,
                            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i>',
                            'overwriteInitial'=>false,
                        ]
                    ]);
                ?><br>
			<?php } ?>

		    <?= $form->field($model, 'konten')->widget(TinyMce::className(), [
	            'options' => ['rows' => 30],
	            'language' => 'id',
	            'clientOptions' => [
	                'plugins' => [
	                    "advlist autolink lists link charmap print preview anchor",
	                    "searchreplace visualblocks code fullscreen",
	                    "insertdatetime media table contextmenu paste image imagetools"
	                ],

	                // 'menubar' => ["insert"],
	                'automatic_uploads' => false,
	                'file_picker_types' => 'image',
	                'images_upload_url' => Url::to(['artikel/upload']),
	                'images_upload_handler' => new \yii\web\JsExpression("function(blobInfo, success, failure) {
	                    var xhr, formData;
	        
	                    xhr = new XMLHttpRequest();
	                    xhr.withCredentials = true;
	                    xhr.open('POST', '" . Url::to(['artikel/upload']) . "');
	        
	                    xhr.onload = function() {
	                        var json;
	                        var _crsf = yii.getCsrfToken();
	                        if (xhr.status != 200) {
	                            failure('HTTP Error: ' + xhr.status);
	                            return;
	                        }
	                        console.log(_crsf);
	                        json = JSON.parse(xhr.responseText);
	        
	                        if (!json || typeof json.file_path != 'string') {
	                            failure('Invalid JSON: ' + xhr.responseText);
	                            return;
	                        }
	                        
	                        success(json.file_path);
	                    };
	                    function getMeta(metaName) {
	                        const metas = document.getElementsByTagName('meta');
	                      
	                        for (let i = 0; i < metas.length; i++) {
	                          if (metas[i].getAttribute('name') === metaName) {
	                            return metas[i].getAttribute('content');
	                          }
	                        }
	                      
	                        return '';
	                      }
	                    formData = new FormData();
	                    formData.append('file', blobInfo.blob(), blobInfo.filename());
	                    formData.append( $('meta[name=csrf-param]').attr('content'), yii.getCsrfToken());
	                    xhr.send(formData);
	                }"),
	                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image imageupload | fontselect | cut copy paste"
	            ]
	        ]); ?>

		    <div class="form-group">
		        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-danger']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>	
		</div>
	</div>
</div>
