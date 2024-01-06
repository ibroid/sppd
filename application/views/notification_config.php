<div class="content-wrapper container">
  <div class="page-heading">
    <h3>TEST WA NOTIFIKASI</h3>
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

          <form action="<?= base_url("app/notif_test") ?>" method="post" class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon (Pakai Kode Negara)</label>
                <input required type="number" name="nomor_telepon" placeholder="Contoh : 6289636811489" class="form-control">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="nomor_telepon">...</label>
                <br>
                <button class="btn btn-primary">Test Notifikasi</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</div>