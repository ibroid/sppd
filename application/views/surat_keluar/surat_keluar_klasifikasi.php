<div class="content-wrapper container-fluid container">
  <div class="page-heading">
    <h3>Kelola Surat Keluar</h3>
  </div>
  <div class="page-content ">
    <?php if (pengaturan()->maintenance == 1) { ?>
      <div class="alert alert-danger">
        <strong>
          MAINTENANCE. TOLONG JANGAN DI PAKAI
        </strong>
      </div>
    <?php } ?>
    <?php if ($this->session->flashdata('notif') or $this->session->flashdata('notif_file')) { ?>
      <div class="alert alert-info">
        <strong>
          <?= $this->session->flashdata('notif') ?><br>
          <?= $this->session->flashdata('notif_file') ?>
        </strong>
      </div>
    <?php } ?>
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Kontrol Surat Keluar dengan Klasifikasi <?= $kode ?> (<?= $name ?>)</h5>
      </div>

      <div class="card-body">
        <br>
        <form action="<?= base_url('surat_keluar/klasifikasi/' . $kode) ?>" method="POST">
          <div class="row">
            <div class="col-md-6">
              <label for="">Cari Berdasarkan Periode Tanggal Dikirim</label>
              <div class="input-group mb-4">
                <input type="text" class="form-control datepicker" name="awal">
                <input type="text" class="form-control datepicker" name="akhir">
                <button class="btn btn-primary" type="submit" id="button-addon2">Cari</button>
                <a class="btn btn-outline-danger" href="<?= base_url('/surat/surat_keluar?reset=1') ?>" id="button-addon2">reset</a>
              </div>
            </div>
          </div>
        </form>
        <table id="tableSuratKeluar" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Tujuan</th>
              <th>Nomor Surat</th>
              <th>Tanggal Surat</th>
              <th>Perihal</th>
              <th>Tanggal Dikirim</th>
              <th>File</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>

          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalEdit" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Edit Data Surat Keluar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" onsubmit="Swal.fire({
                                title: 'Mohon Tunggu',
                                willOpen: () => Swal.showLoading(),
                                backdrop: true,
                                allowOutsideClick: false,
                                showConfirmButton: false })" action="<?= base_url('/surat/update_surat_keluar') ?>" method="post" enctype="multipart/form-data" class="form form-horizontal">
          <input type="hidden" id="hidden-surat-id" name="id">
          <div class="form-body">
            <div class="row">
              <div class="col-md-1">
              </div>
              <div class="col-md-3">
                <label class="align-right">Tujuan Surat <i class="text-danger inline">*</i></label>
              </div>
              <div class="col-md-7 form-group">
                <input type="text" id="edit-input-tujuan-surat" class="form-control" name="tujuan" placeholder="Tujuan Surat : Wajib Di Isi" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
              </div>
              <div class="col-md-3">
                <label class="text-end">Tanggal Surat <i class="text-danger inline">*</i></label>
              </div>
              <div class="col-md-7 form-group">
                <input type="date" id="input-tanggal-surat" class="form-control" name="tanggal_surat" placeholder="Tanggal Surat : Wajib Di Isi" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
              </div>
              <div class="col-md-3">
                <label class="text-end">Tanggal Dikirim <i class="text-danger inline">*</i></label>
              </div>
              <div class="col-md-7 form-group">
                <input type="date" id="input-tanggal-dikirim" class="form-control" name="tanggal_dikirim" placeholder="Tanggal Diterima : Wajib Di Isi" required value="<?= date('Y-m-d') ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
              </div>
              <div class="col-md-3">
                <label class="text-end">Perihal</label>
              </div>
              <div class="col-md-7 form-group">
                <input type="text" id="input-perihal" class="form-control" name="perihal" placeholder="Perihal">
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
              </div>
              <div class="col-md-3">
                <label class="text-end">Ringkasan Isi</label>
              </div>
              <div class="col-md-7 form-group">
                <textarea id="textarea-ringkasan-isi" name="ringkasan_isi" class="form-control" cols="5" rows="3"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
              </div>
              <div class="col-md-3">
                <label class="text-end">Catatan</label>
              </div>
              <div class="col-md-7 form-group">
                <input type="text" id="input-catatan" class="form-control" name="catatan" placeholder="Catatan">
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-sm-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary me-1 mb-1">
                  Simpan
                </button>
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                  Reset
                </button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-1">
              </div>
              <div class="col-md-10">
                <div class="alert alert-light-danger color-danger">
                  <i class="bi bi-exclamation-circle"></i> Form dengan tanda bintang merah wajib diisi
                </div>
              </div>

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
  var modalEdit = null;
  $(document).ready(() => {

    modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'))
    $('#tableSuratKeluar').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": '<?= base_url('surat_keluar/datatable_klasifikasi/' . $kode) ?>',
        "type": "POST"
      }
    });
  })
  const uploadFile = async (id) => {
    Swal.fire({
      title: 'Pilih Dokumen Surat Keluar',
      input: 'file',
      showCancelButton: true,
      confirmButtonText: 'Upload',
      showLoaderOnConfirm: true,
      backdrop: true,
      allowOutsideClick: () => !Swal.isLoading(),
      preConfirm: (value) => {
        const body = new FormData()
        body.append('file', value)
        body.append('id', id)
        return fetch(`<?= base_url('surat/update_surat_keluar') ?>`, {
            method: 'POST',
            body
          })
          .then(response => {
            if (!response.ok) {
              throw new Error(response.statusText)
            }
            return response.json()
          })
          .catch(error => {
            Swal.showValidationMessage(
              `Request failed: error`
            )
          })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(result.value)
          .then(() => location.reload())
      }
    })
  }

  const deleteData = (id) => {
    Swal.fire({
      title: 'Apa anda yakin ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Hapus',
      showLoaderOnConfirm: true,
      preConfirm: (value) => {
        const body = new FormData()
        body.append('id', id)
        return fetch(`<?= base_url('surat/hapus_surat_keluar') ?>`, {
            method: 'POST',
            body
          })
          .then(response => {
            if (!response.ok) {
              throw new Error(response.statusText)
            }
            return response.json()
          })
          .catch(error => {
            Swal.showValidationMessage(
              `Request failed: error`
            )
          })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(result.value)
          .then(() => location.reload())
      }
    })
  }

  const editData = (el) => {
    const data = JSON.parse(el.dataset.json)
    $('#hidden-surat-id').val(data.id)
    $('#edit-input-tujuan-surat').val(data.tujuan)
    $('#input-tanggal-surat').val(data.tanggal_surat)
    $('#input-tanggal-dikirim').val(data.tanggal_dikirim)
    $('#input-perihal').val(data.perihal)
    $('#textarea-ringkasan-isi').val(data.ringkasan_isi)
    $('#input-catatan').val(data.catatan)
    modalEdit.show()
  }

  const deleteSuratMasuk = async (id) => {
    const decission = await Swal.fire({
      title: "Apa anda akan menghapus Nomor Surat Ini ?",
      text: "Apabila di hapus. Surat Dinas atau Surat Tugas yang berkaitan akan ikut terhapus nomor surat nya.",
      showCancelButton: true,
      icon: "warning"
    })

    if (decission.isConfirmed) {
      const body = new FormData;

      body.append('id', id);

      fetch("<?= base_url('penomoran/hapus_nomor_surat') ?>", {
          method: "POST",
          body
        })
        .then(res => {
          if (!res.ok) {
            throw new Error(res.statusText);
          }
          return res.json();
        })
        .then(res => {
          Swal.fire(res.status, res.message).then(() => location.reload())
        })
        .catch(err => {
          Swal.fire('Terjadi Kesalahan', err.message, 'error')
        })
    }

  }
</script>