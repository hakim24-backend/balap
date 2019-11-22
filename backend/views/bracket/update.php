<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Bracket */

$this->title = 'Update Bracket: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Brackets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="bracket-form">
	<div class="box box-info">
		<div class="box-body">
			<?php $form = ActiveForm::begin(); ?>

			<label>Batas Brucket</label>
			<input id="batas" class="form-control" type="number" name="batas" min="0" value="<?=$batas?>" step=".01"><br>

			<label>Batas Atas</label>
			<input id="batas_atas" class="form-control" type="number" name="batas_atas" min="0" value="<?=$batas_atas?>" step=".01"><br>

			<label>Batas Bawah</label>
			<input id="batas_bawah" class="form-control" type="number" name="batas_bawah" min="0" value="<?=$batas_bawah?>" step=".01"><br>

		    <div class="form-group">
		        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-danger']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>	
		</div>
	</div>
</div>

<?php

    $this->registerJs("

    	$('.btn-success').on('click',function(){
    		var batas = $('#batas').val();
    		var ba = $('#batas_atas').val();
    		var bb = $('#batas_bawah').val();

    		if(batas == 0){
    			swal('Warning', 'Batas Brucket Harus Diisi', 'warning');
    			return false;
    		}

    		if(ba == 0){
    			swal('Warning', 'Batas Atas Harus Diisi', 'warning');
    			return false;
    		}

    		if(bb == 0){
    			swal('Warning', 'Batas Bawah Harus Diisi', 'warning');
    			return false;
    		}

        });
    ")
?>
