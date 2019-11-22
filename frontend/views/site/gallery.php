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
      </div>

    </section>