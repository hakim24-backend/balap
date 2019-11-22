<?php

use yii\helpers\Url;

?>
<!--==========================
  Speaker Details Section
============================-->
<section id="speakers-details" class="wow fadeIn">
  <div class="container">
    <div class="section-header">
      <h2>Hasil Race</h2>
      <p>List Hasil Race Untuk HEAT 1 dan HEAT 2</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="row">
          <a href="<?=Url::to(['site/heat-one','id' => $id])?>" class="col-md-6  text-center">
            <div class="box-sm">
              <span><strong>HEAT 1</strong></span>
            </div>
          </a>
          <a href="<?=Url::to(['site/heat-two','id' => $id])?>" class="col-md-6  text-center">
            <div class="box-sm">
              <span><strong>HEAT 2</strong></span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>