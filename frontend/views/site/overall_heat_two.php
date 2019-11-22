<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

?>

<!--==========================
  Speaker Details Section
============================-->
<section id="speakers-details" class="wow fadeIn">
  <div class="container">
    <div class="section-header">
      <h2>HEAT 2</h2>
      <p>Hasil Race</p>
    </div>

    <p style="color: #fff;">INDONESIA DRAG FEST 2019<br>
    HASIL RACE HEAT 2<br>
    Timer By SRP<br>

    <table class="table table-hover">
      <thead class="bg-danger">
        <th>Posisi</th>
        <th>No. Start</th>
        <th>Nama</th>
        <th>Team</th>
        <th>Kendaraan</th>
        <th>Kota</th>
        <th>RT</th>
        <th>ET60</th>
        <th>ET</th>
        <th>TIME</th>
      </thead>
      <tbody>
        <?php $no = 1; foreach ($model as $key => $value) { ?>
          <tr>
            <td><?=$no++?></td>
            <td><?=$value->NO_START?></td> 
            <td><?=$value->NAMA?></td>
            <td><?=$value->TEAM?></td>
            <td><?=$value->KENDARAAN?></td>
            <td><?=$value->KOTA?></td>
            <td><?=$value->RT?></td>
            <td><?=$value->ET60?></td>
            <td><?=$value->ET?></td>
            <td><?=$value->TIME?></td>
          </tr>
        <?php } ?>
      </tbody>
    
    </table>
  </div>
</section>