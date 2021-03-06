<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header" data-background-color="blue">
        <h4 class="title">Pengajuan Proyek</h4>
        <p class="category">Isi formulir dibawah ini sesuai dengan kebutuhan proyek yang Anda ajukan.</p>
      </div>
      <div class="card-content table-responsive">
        <form action="" method="post" enctype="multipart/form-data">
          <h4 class="lead">Data Proyek</h4>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group label-floating">
                <label class="control-label">Nama Proyek *</label>
                <input type="text" class="form-control" name="nama_proyek" required autofocus>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group label-floating">
                <label class="control-label">Deadline Kebutuhan *</label>
                <input type="text" id="datepicker" class="form-control" name="selesai" pattern="([0-9]{4})+-+([0-1]{1})+([0-9]{1})+-+([0-3]{1})+([0-9]{1})" autocomplete="off" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Keterangan</label>
                <div class="form-group label-floating">
                  <textarea class="form-control" name="keterangan" rows="6" placeholder="Keterangan tambahan jika diperlukan"></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">File Tambahan <span class="text-info">(.zip, .rar)</span></label>
                <input type="file" class="form-control" name="file" style="opacity: 1; position: inherit;">
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
          <hr>

          <h4 class="lead">Data Pemohon</h4>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group label-floating">
                <label class="control-label">Nama Anda *</label>
                <input type="text" class="form-control" name="nama" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group label-floating">
                <label class="control-label">Email *</label>
                <input type="text" class="form-control" name="email" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group label-floating">
                <label class="control-label">Instansi*</label>
                <input type="text" class="form-control" name="instansi" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group label-floating">
                <label class="control-label">Kontak <span class="text-info">(HP/LINE/WA)</span></label>
                <input type="text" class="form-control" name="kontak" required>
              </div>
            </div>
          </div>

          <input type="submit" class="btn btn-success btn-lg btn-block" name="ajukan" value="Ajukan">

        </form>
      </div>
    </div>
  </div>
</div>
