<div class="row">
  <div class="col-md-12">
    <a href="<?= site_url('u/add-kategori'); ?>" class="btn btn-primary">
      <i class="material-icons">note_add</i> Tambah
    </a>

    <a href="<?= site_url('u/project'); ?>" class="btn btn-default">
      <i class="material-icons">ballot</i> Project
    </a>
  </div>

  <div class="col-md-12">
    <div class="card">
      <div class="card-header" data-background-color="blue">
        <h4 class="title">Kategori Project</h4>
        <!-- <p class="category">Here is a subtitle for this table</p> -->
      </div>
      <div class="card-content table-responsive">
        <table class="table">
          <tbody>

            <?php foreach($kategori as $item): ?>
              <tr>
                <td>#<?= $item->id; ?></td>
                <td><?= $item->nama; ?></td>
                <td class="td-actions text-right">
                  <a href="<?= site_url('u/edit-kategori/'.$item->id); ?>" rel="tooltip" title="Edit kategori" class="btn btn-primary btn-simple btn-xs">
                    <i class="material-icons">edit</i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
