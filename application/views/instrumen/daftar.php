<div class="content-wrapper container">
    <div class="page-content">
        <?php if ($this->session->flashdata('notif')) { ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                    <use xlink:href="#info-fill" />
                </svg>
                <div>
                    <?php echo $this->session->flashdata('notif') ?>
                </div>
            </div>
        <?php } ?>
        <h4>Pengaturan Isntrumen</h4>
        <div class="card">
            <div class="card-body">
                <form action="" id="penandatangan" method="post">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <form action="" method="POST" id="formPenandatangan">
                                <label for="template">Pilih Penanda Tangan</label>
                                <select class="form-control" name="penandatangan">
                                    <option value="Ketua" selected>Ketua (Default)</option>
                                    <option>Wakil</option>
                                    <option>Panitera</option>
                                    <option>Sekretaris</option>
                                    <?php foreach ($plh as $p) { ?>
                                        <option value="<?= $p->id ?>">(PLH) <?= $p->nama_pejabat ?></option>
                                    <?php } ?>
                                </select>
                                <button class="btn btn-success mt-4">Simpan</button>
                            </form>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <h4>Daftar Isntrumen</h4>
        <div class="card">
            <div class="card-body">
                <table id="daftar" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tujuan</th>
                            <th>Maksud</th>
                            <th>Perihal</th>
                            <th>Tanggal Penugasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($instrumen as $num => $ins) { ?>
                            <tr>
                                <td><?= ++$num ?></td>
                                <td><?= $ins->tujuan ?></td>
                                <td><?= $ins->maksud ?></td>
                                <td><?= $ins->perihal ?></td>
                                <td><?= format_tanggal($ins->tanggal_penugasan)  ?></td>
                                <td>
                                    <a href="<?= base_url('instrumen/cetak/' . $ins->id) ?>" class="btn btn-sm btn-success"><i class="bi bi-printer"></i></a>
                                    <a href="<?= base_url('instrumen/delete/' . $ins->id) ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {

        const datatable = new simpleDatatables.DataTable('#daftar');

        $('#formPenandatangan').on('submit', async (e) => {
            Swal.showLoading();
            e.preventDefault()
            const body = new FormData(document.getElementById('formPenandatangan'))
            const postReq = await fetch("<?= base_url('penugasan/surat_tugas_penandatangan') ?>", {
                method: 'POST',
                body: body
            }).then(res => res.json())

            console.log(postReq);

            Swal.fire("Penandatangan berhasil Dipilih");
        })
    })
</script>