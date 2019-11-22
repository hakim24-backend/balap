<?php
  $root = Yii::$app->request->baseUrl;
  use yii\helpers\Url;
?>

<section id="artikeldetail-details" class="wow fadeIn">
  <div class="container">

    <div class="row">
      <div class="col-md-6">
        <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/artikel/'.$model->gambar ?>" alt="Speaker 1" class="img-fluid">
      </div>

      <div class="col-md-6">
        <div class="details">
          <h2><?=$model->judul?></h2>

          <span><?=date_format(date_create($model->datetime_created), 'd F Y')?></span>

          <p style="margin-top: 20px;">
            <?php
              $artikel = str_replace('../../img/', $root.'../img/', $model->konten);
              echo $artikel;
            ?>
          </p>

          <?php if ($file != null) { ?>
            <ul class="list-unstyled" style="color: #fff; font-weight: bold;">Download :
              <?php foreach ($file as $key => $value) { ?>
                <li><a href="<?=Url::to(['site/download-artikel','id' => $value->id])?>"><?=$value->filename?></a></li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>