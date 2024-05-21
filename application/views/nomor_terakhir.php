<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Pengaturan Nomor Terakhir Surat Keluar</h3>
  </div>
  <div class="page-content">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <?php if ($this->session->flashdata('notif')) { ?>
            <div class="alert alert-primary">
              <i class="bi bi-info-circle-fill"></i> <?= $this->session->flashdata('notif')  ?>.<br>
            </div>
          <?php } ?>

          <table class="table table-responsive table-striped table-hover table-bordered">
            <thead class="text-center">
              <tr>
                <th>Klasifikasi</th>
                <th>Nomor Terakhir</th>
                <th>Aksi</th>
              </tr>
            <tbody>
              <?php foreach ($jenis_nomor as $r) { ?>
                <form action="<?= base_url("penomoran/update_nomor_terakhir/" . $r->id) ?>" method="POST">
                  <tr>
                    <td><?= $r->kode ?></td>
                    <td>
                      <input type="number" class="form-control" name="nomor" value="<?= $r->nomor ?>">
                    </td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-light-primary">Update</button>
                    </td>
                  </tr>
                </form>
              <?php } ?>
            </tbody>

            </thead>

          </table>
        </div>
      </div>
    </section>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Hak Penomoran</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-body-form">
        <form action="<?= base_url("penomoran/tambah_hak") ?>" method="post">
          <div class="form-group">
            <label for="role_name">Nama Role</label>
            <input type="text" disabled id="role_name" class="form-control">
            <input type="hidden" id="role_id" name="role_id">
          </div>
          <table class="table">
            <?php foreach ($jenis_nomor as $jn) { ?>
              <tr>
                <td><?= $jn->kode ?></td>
                <td><input type="checkbox" value="<?= $jn->kode ?>" name="kode[]"></td>
              </tr>
            <?php } ?>
          </table>
          <button class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>