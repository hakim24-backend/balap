<section>
  <div class="container">
    <div class="mt-5 text-center">

      <h3 class="text-center mt-2">HASIL RACE HEAT 1</h3>

      <div class="col-md-12 text-center">
        <span>INDONESIA DRAG FEST 2019</span><br>
    	<span>Kelas <?=$kelas->NOMORKELAS?> Kategori <?=$kelas->NAMAKELAS?></span><br>
    	<span>Waktu Print <?= date_format(date_create(date('Y-m-d')), 'd F Y') ?>, <?= date('H:i:s') ?></span><br>
    	<span>Timer By SRP</span>
      </div>
    </div>
  </div>

  <hr>

  <div class="container">
    <div class="row">
      <div class="col-md-12">

      	<table class="sponsor" style="border: unset; width: 100%; text-align: center;">
			<tr>
				<td style="width: 50%;"><img src="img/supporters/1.png" width="30%"></td>
				<td style="width: 50%;"><img src="img/supporters/2.png" width="30%"></td>
			</tr>
		</table><br>

      	<table class="item" border="1" style="width: 100%; text-align: center;">
          <thead class="bg-danger">
          	<tr>
          		<th class="text-center">Posisi</th>
	            <th class="text-center" width="10%">No. Start</th>
	            <th class="text-center">Nama</th>
	            <th class="text-center">Team</th>
	            <th class="text-center">Kendaraan</th>
	            <th class="text-center">Kota</th>
	            <th class="text-center">RT</th>
	            <th class="text-center">ET60</th>
	            <th class="text-center">ET</th>
	            <th class="text-center">TIME</th>
          	</tr>
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
        </table><br>

        <table class="sponsor" style="border: unset; width: 100%; text-align: center;">
        	<tr>
        		<td style="width: 50%;"><img src="img/supporters/1.png" width="30%"></td>
        		<td style="width: 50%;"><img src="img/supporters/2.png" width="30%"></td>
        	</tr>
        </table>

      </div>
    </div>
  </div>
</section>