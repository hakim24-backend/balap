<!--==========================
      Speaker Details Section
    ============================-->
    <section id="speakers-details" class="wow fadeIn">
      <div class="container">
        <div class="section-header">
          <h2>Daftar Peserta</h2>
          <p>List Peserta Kelas <?=$kategori->NOMORKELAS?> Kategori <?=$kategori->NAMAKELAS?></p>
        </div>

        <table class="table table-hover">
          <thead class="bg-danger">
            <th>Posisi</th>
            <th>No. Start</th>
            <th>Nama</th>
            <th>Team</th>
            <th>Kendaraan</th>
            <th>Kota</th>
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
              </tr>
            <?php } ?>
          </tbody>
        
        </table>
      </div>
    </section>