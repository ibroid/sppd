<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Pengaturan Hak Akses Penomoran</h3>
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
                <th>No</th>
                <th>Nama Role</th>
                <th>Hak Penomoran</th>
                <th>Aksi</th>
              </tr>
            <tbody>
              <?php foreach ($roles as $k => $r) { ?>
                <tr>
                  <td><?= ++$k ?></td>
                  <td><?= $r->role_name ?></td>
                  <td>
                    <?php foreach ($r->hak_penomoran as $hak_penomoran) { ?>
                      <span class="badge bg-primary">
                        <?= $hak_penomoran->kode ?>
                      </span>
                    <?php } ?>
                  </td>
                  <td class="text-center">
                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" onclick='setParameter(<?= $r ?>)' class="btn btn-sm btn-light-primary">Kelola Hak</button>
                  </td>
                </tr>
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


<script src="<?= base_url('assets/js/autocomplete.js') ?>"></script>

<script>
  function setParameter(data) {
    // $("#role_name").val(data.role_name)
    // $("#role_id").val(data.id)
    $.ajax({
      url: "<?= base_url("penomoran/fetch_form") ?>",
      method: "post",
      data: {
        role_id: data.id
      },
      success: function(response) {
        $("#modal-body-form").html(response)
      },
      error(error) {
        $("#modal-body-form").html(error.responseText)
      }
    });
  }
</script>