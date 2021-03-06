
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header" data-background-color="blue">
        <h4 class="title">Detail Request</h4>
        <p class="card-category">Tanggapan akan langsung dikirimkan ke email pemohon</p>
      </div>
      <div class="card-content">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-hover">
              <tr>
                <th>Nama Proyek</th>
                <td><?= $request->nama; ?></td>
              </tr>
              <tr>
                <th>Pengajuan - Deadline</th>
                <td>
                  <?= tanggal_definer($request->tgl_pengajuan) .' - <strong>'. tanggal_definer($request->est_selesai) .'</strong>' ?>
                </td>
              </tr>
              <tr>
                <th>Status</th>
                <td><?= status_definer($request->status); ?></td>
              </tr>
              <tr>
                <th>Pemohon</th>
                <td><?= $request->nama_pemohon; ?></td>
              </tr>
              <tr>
                <th>Instansi</th>
                <td><?= $request->instansi; ?></td>
              </tr>
              <tr>
                <th>Kontak</th>
                <td><?= $request->kontak ?></td>
              </tr>
              <tr>
                <th>File Tambahan</th>
                <?php if($request->file == null){ ?>  
                  <td><i>Tidak ada</i></td>
                <?php } else { ?>
                  <td><a href="<?= base_url('uploads/proposals/'.$request->file); ?>" target="_blank">Buka</a></td>
                <?php } // end else ?>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <blockquote style="text-align: justify;"><?= $request->ket == '' ? '<i>Keterangan kosong</i>' : $request->ket; ?></blockquote>
          </div>
        </div>

        <div class="clearfix"></div>
        <hr>

        <?php if($riwayat != NULL): ?>
          <div class="row">
            <div class="col-sm-12">
              <h4 class="lead">Riwayat Tanggapan</h4>
              <table class="table table-striped">
                <thead>
                  <tr class="text-danger">
                    <th>Tanggal</th>
                    <th>Tanggapan</th>
                    <th>Club</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($riwayat as $item): ?>
                    <tr>
                      <td><?= tanggal_definer($item->tgl); ?></td>
                      <td><?= status_definer($item->dari_status) .' -> <strong>'. status_definer($item->ke_status) .'</strong>' ; ?></td>
                      <td><?= $item->nama_club .' ('. $item->nama_user .')' ; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>

        <?php if($request->status == 'N'): ?>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <button type="button" id="terima" class="btn btn-success btn-lg btn-block" onclick="terima()"><i class="fa fa-check"></i> Terima</button>
            </div>
            <div class="col-sm-12 col-md-6">
              <button type="button" id="tolak" class="btn btn-danger btn-lg btn-block" onclick="tolak()"><i class="fa fa-close"></i> Tolak</button>
            </div>
          </div>
        <?php endif; ?>

        <?php if($request->status == 'Y'): ?>
          <div class="row">
            <div class="col-sm-12">
              <?php if($item->level_user == $this->session->userdata('level')){ ?>
                <button type="button" id="selesai" class="btn btn-success btn-lg btn-block" onclick="selesai()"><i class="fa fa-check"></i> Tandai Sudah Selesai</button>
              <?php } else { ?>
                <button type="button" id="selesai" class="btn btn-default btn-lg btn-block" disabled><i class="fa fa-ban"></i> Tidak bisa menandai selesai</button>
              <?php } ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
<?php if($request->status == 'N'): ?>
function terima(){
  var c = confirm('Dengan melanjutkan, anda sebagai perwakilan club <?= $this->session->userdata('club_slug'); ?> menerima proyek ini.');
  if(c){
    window.location = "<?= site_url('c/terima-request/'.$request->id); ?>";
  }
}
function tolak(){
  var c = confirm('Request yang ditolak tidak bisa dikembalikan lagi. Apakah Anda yakin?');
  if(c){
    window.location = "<?= site_url('c/tolak-request/'.$request->id); ?>";
  }
}
<?php endif; ?>
<?php if($request->status == 'Y' && $item->level_user == $this->session->userdata('level')): // mengurangi kecurigaan wkwk ?>
function selesai(){
  var c = confirm('Tandai sebagai SELESAI?');
  if(c){
    window.location = "<?= site_url('c/selesai-request/'.$request->id); ?>";
  }
}
<?php endif; ?>
</script>
