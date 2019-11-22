<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

?>
    <!--==========================
      About Section
    ============================-->
    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h2>Tentang Kami</h2>
            <p>Sed nam ut dolor qui repellendus iusto odit. Possimus inventore eveniet accusamus error amet eius aut
              accusantium et. Non odit consequatur repudiandae sequi ea odio molestiae. Enim possimus sunt inventore in
              est ut optio sequi unde.</p>
          </div>
          <div class="col-lg-3">
            <h3>Where</h3>
            <p>Sirkuit Sentul, Jakarta</p>
          </div>
          <div class="col-lg-3">
            <h3>When</h3>
            <p>Sabtu-Minggu<br>10-12 Desember</p>
          </div>
        </div>
      </div>
    </section>

    <!--==========================
      Schedule Section
    ============================-->
    <section id="schedule" class="section-with-bg">
      <div class="container wow fadeInUp">
        <div class="section-header">
          <h2>Jadwal Acara</h2>
          <p>Here is our event schedule</p>
        </div>

        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#day-1" role="tab" data-toggle="tab">Jadwal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#day-2" role="tab" data-toggle="tab">Peserta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#day-3" role="tab" data-toggle="tab">Hasil Race</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#day-4" role="tab" data-toggle="tab">Hasil Overall Race</a>
          </li>
        </ul>

        <h3 class="sub-heading">Untuk jadwal, peserta dan hasil race bisa dilihat dibawah ini</h3>

        <div class="tab-content row justify-content-center">

          <!-- Schdule Day 1 -->
          <div role="tabpanel" class="col-lg-9 tab-pane fade show active" id="day-1">

            <?php foreach ($jadwal as $key => $value) { ?>
              <div class="row schedule-item">
                <div class="col-md-3"><time><?= date_format(date_create($value->date), 'd F Y') ?></time><time><?= date('g:i A', strtotime($value->time)) ?></time></div>
                <div class="col-md-9">
                  <h4><?=$value->name?></h4>
                  <p><?=$value->location?></p>
                </div>
              </div>
            <?php } ?>

            <div class="row justify-content-center mt-3">
              <a href="<?=Url::to(['site/jadwal'])?>" class="btn btn-denger text-center">Lihat Selengkapnya</a>
            </div>

          </div>
          <!-- End Schdule Day 1 -->

          <!-- Schdule Day 2 -->
          <div role="tabpanel" class="col-lg-9  tab-pane fade" id="day-2">

            
            <div class="row justify-content-center">
              <?php foreach ($setKelas as $key => $value) { ?>
                <a href="<?=Url::to(['site/list-peserta','id' => $value->NOMORKELAS])?>" class="col-md-2 box-sm text-center">
                  <span class="text-center"><strong>Kelas <?=$value->NOMORKELAS?></strong></span>
                </a>
              <?php } ?>
            </div>

          </div>
          <!-- End Schdule Day 2 -->

          <!-- Schdule Day 3 -->
          <div role="tabpanel" class="col-lg-9  tab-pane fade" id="day-3">

            <div class="row justify-content-center">
              <?php foreach ($setKelas as $key => $value) { ?>
                <a href="<?=Url::to(['site/hasil-tanding','id' => $value->NOMORKELAS])?>" class="col-md-2 box-sm text-center">
                  <span class="text-center"><strong>Kelas <?=$value->NOMORKELAS?></strong></span>
                </a>
              <?php } ?>
            </div>

          </div>
          <!-- End Schdule Day 3 -->

          <!-- Schdule Day 3 -->
          <div role="tabpanel" class="col-lg-9  tab-pane fade" id="day-4">

            <div class="row justify-content-center">
                <a href="<?=Url::to(['site/heat-one-overall'])?>" class="col-md-2 box-sm text-center">
                  <span class="text-center"><strong>HEAT 1</strong></span>
                </a>
                <a href="<?=Url::to(['site/heat-two-overall'])?>" class="col-md-2 box-sm text-center">
                  <span class="text-center"><strong>HEAT 2</strong></span>
                </a>
            </div>

          </div>
          <!-- End Schdule Day 3 -->

        </div>

      </div>

    </section>

    <!--==========================
      Venue Section
    ============================-->
    <section id="venue" class="wow fadeInUp">

      <div class="container-fluid venue-gallery-container">
        <div class="section-header">
          <h2>Gallery</h2>
          <p>Here is our Gallery</p>
        </div>

        <div class="row no-gutters">

          <?php foreach ($gallery as $key => $value) { ?>
            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a href="<?= Yii::$app->request->baseUrl . '/frontend/web/img/gallery/'.$value->filename ?>" class="venobox" data-gall="venue-gallery">
                  <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/gallery/'.$value->filename ?>" alt="" class="img-fluid">
                </a>
              </div>
            </div>
          <?php } ?>

        </div>

        <div class="row justify-content-center mt-3">
          <a href="<?=Url::to(['site/gallery'])?>" class="btn btn-denger text-center">Lihat Selengkapnya</a>
        </div>
      </div>

    </section>

    <!--==========================
      Hotels Section
    ============================-->
    <section id="articles" class="section-with-bg wow fadeInUp">

      <div class="container">

        <div class="section-header">
          <h2>Artikel</h2>
          <p>Artikel kami</p>
        </div>

        <div class="row">
          <?php foreach ($artikel as $key => $value) { ?>
            <div class="col-lg-4 col-md-6">
              <div class="articleblp">
                <div class="articleblp-img">
                  <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/artikel/'.$value->gambar ?>" alt="articleblp 1" class="img-fluid">
                </div>
                <h3><a href="<?=Url::to(['site/detail-artikel','id' => $value->id])?>"><?=$value->judul?></a></h3>
                <!-- <div class="stars">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                </div> -->
                <p><?= strip_tags(substr($value->konten, 0, 200)) ?>.....<a href="<?=Url::to(['site/detail-artikel','id' => $value->id])?>">Read More</a></p>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

    </section>

    <section id="supporters" class="section-with-bg wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">

      <div class="container">
        <div class="section-header">
          <h2>Sponsors</h2>
        </div>

        <div class="row no-gutters supporters-wrap justify-content-center clearfix">

          <?php foreach ($sponsor as $key => $value) { ?>
            <div class="col-lg-3 col-md-4 col-xs-6">
              <div class="supporter-logo">
                <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/sponsor/'.$value->filename ?>" class="img-fluid" alt="">
              </div>
            </div>
          <?php } ?>

        </div>

      </div>

    </section>


    <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="section-bg wow fadeInUp">

      <div class="container">

        <div class="section-header">
          <h2>Kontak Kami</h2>
          <p>CV. Mamorasoft</p>
        </div>

        <div class="row contact-info">

          <div class="col-md-4">
            <div class="contact-address">
              <i class="ion-ios-location-outline"></i>
              <h3>Alamat</h3>
              <address>Jl. Ploso Baru No. 110</address>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-phone">
              <i class="ion-ios-telephone-outline"></i>
              <h3>Nomer Telepon</h3>
              <p><a href="tel:+155895548855">+62 5589 55488 55</a></p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-email">
              <i class="ion-ios-email-outline"></i>
              <h3>Email</h3>
              <p><a href="mailto:info@example.com">info@example.com</a></p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- #contact -->
