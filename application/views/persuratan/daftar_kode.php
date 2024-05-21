<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

<div class="content-wrapper container">
    <div class="page-heading">
        <h3>Referensi Kode Surat</h3>
    </div>
    <div class="page-content ">
        <?php if ($this->session->flashdata('notif') or $this->session->flashdata('notif_file')) { ?>
            <div class="alert alert-info">
                <strong>
                    <?= $this->session->flashdata('notif') ?><br>
                </strong>
            </div>
        <?php } ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tabel</h5>
            </div>
            <div class="card-body">
                <form id="form-kode-surat" action="<?= base_url('/penomoran/save_kode') ?>" method="POST">
                    <div class="row">
                        <div class="col-md-2">
                            <input required type="text" id="input-kode-surat" name="kode_surat" placeholder="Kode Surat" class="form-control">
                        </div>
                        <div class="col-md">
                            <textarea required placeholder="Keterangan Kode Surat" name="keterangan" maxlength="1564" id="textarea-keterangan" class="form-control" rows="1"></textarea>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex">
                                <button class="btn btn-success">Simpan</button>
                                <button onclick="$('#form-kode-surat').attr('<?= base_url('/penomoran/save_kode') ?>')" type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $value) { ?>
                            <tr>
                                <td><?= ++$key ?></td>
                                <td><?= $value->kode_surat ?></td>
                                <td><?= $value->keterangan ?></td>
                                <td><button onclick='fetch_edit(<?= $value ?>)' class="btn btn-sm btn-warning">Ubah</button><button onclick="hapus(<?= $value->id ?>)" class="btn btn-sm btn-danger">Hapus</button></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const fetch_edit = (data) => {
        $("#input-kode-surat").val(data.kode_surat)
        $("#textarea-keterangan").val(data.keterangan)
        $("#form-kode-surat").attr("action", "<?= base_url('/penomoran/save_kode') ?>/" + data.id)
        window.scrollTo(0, 0);
    }

    const hapus = async (id) => {
        const dec = await Swal.fire({
            title: "Apa anda yakin ?",
            showCancelButton: true,
            icon: "question"
        })

        if (dec.isConfirmed) {
            fetch('<?= base_url('penomoran/hapus_kode') ?>', {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error(res.statusText)
                    }
                    return res.json()
                })
                .then(res => {
                    Swal.fire(res.status, res.message, 'success').then(() => location.reload())
                })
                .catch(err => {
                    Swal.fire('Terjadi Kesalahan', err.message, 'error')
                    console.log(err)
                })
        }
    }
</script>