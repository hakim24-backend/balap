<!--==========================
  Speaker Details Section
============================-->
<section id="schedule" class="wow fadeIn">
  <div class="container">
    <div class="section-header">
      <h2>Jadwal Race</h2>
      <p>Informasi seluruh jadwal race</p>
    </div>

    <div class="row justify-content-center">
      <!-- Schdule Day 1 -->
      <div class="col-lg-9 tab-pane fade show active">

        <?php foreach ($model as $key => $value) { ?>
          <div class="row schedule-item">
            <div class="col-md-3"><time><?= date_format(date_create($value->date), 'd F Y') ?></time><time><?= date('g:i A', strtotime($value->time)) ?></time></div>
            <div class="col-md-9">
              <h4><?=$value->name?></h4>
              <p><?=$value->location?></p>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>
</section>