<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

<div class="content-wrapper container-fluid">
    <div class="page-heading">
        <h3>Generate Surat</h3>
    </div>
    <div class="page-content ">
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
                <h5 class="card-title">Pilih Template</h5>
            </div>
            <div class="card-body">
                <button class="btn btn-success m-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Tambah Template
                </button>
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Template</th>
                            <th>Jenis</th>
                            <th>Tujuan</th>
                            <th>Aksi</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $i => $d) { ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><a href="<?= base_url('surat/generate/' . $d->id) ?>" class="btn btn-primary btn-sm">Generate</a></td>
                                <td><?= $d->nama_template ?></td>
                                <td><?= jenis_template($d->jenis_template)  ?></td>
                                <td><?= $d->keterangan ?></td>
                                <td>
                                    <button onclick="fetchEdit('<?= $d->nama_template ?>', '<?= $d->keterangan ?>', '<?= $d->jenis_template ?>', <?= $d->id ?>)" data-bs-toggle="modal" data-bs-target="#modalEdit" class="btn btn-warning btn-sm">Ubah</button>
                                    <button onclick="beforeDelete(<?= $d->id ?>)" class="btn btn-danger btn-sm">Hapus</button>
                                </td>
                                <td><button class="btn btn-dark btn-sm">Lihat</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-surat-template" autocomplete="off">
                    <div class="form-group">
                        <label for="input-nama-template">Nama Template</label>
                        <input type="text" required id="input-nama-template" class="form-control" name="nama_template">
                    </div>
                    <div class="form-group">
                        <label for="input-keterangan-template">Keterangan Template</label>
                        <input type="text" required id="input-keterangan-template" class="form-control" name="keterangan">
                    </div>
                    <div class="form-group">
                        <label for="input-file-template">File Template</label>
                        <input type="file" required id="input-file-template" class="form-control" name="file">
                    </div>
                    <div class="form-group">
                        <label for="input-file-template">Jenis Template Surat</label>
                        <select required name="jenis_template" id="jenis_template" class="form-control">
                            <option selected value="1">Surat Keluar</option>
                            <option value="2">Instrumen Tugas</option>
                            <option value="3">Surat Tugas</option>
                            <option value="4">Surat Perjalanan Dinas</option>
                            <option value="5">Disposisi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!--
MODAL
TEMPLATE
EDIT
    |--|
    |  |
   _    _
   \    /
    \  / 
     \/
-->
<div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-surat-template-edit" autocomplete="off">
                    <input type="hidden" id="hidden-id-template-edit" name="id">
                    <div class="form-group">
                        <label for="input-nama-template">Nama Template</label>
                        <input type="text" required id="input-nama-template-edit" class="form-control" name="nama_template">
                    </div>
                    <div class="form-group">
                        <label for="input-keterangan-template">Keterangan Template</label>
                        <input type="text" required id="input-keterangan-template-edit" class="form-control" name="keterangan">
                    </div>
                    <div class="form-group">
                        <label for="input-file-template">Jenis Template Surat</label>
                        <select required name="jenis_template" id="jenis_template_edit" class="form-control">
                            <option selected value="1">Surat Keluar</option>
                            <option value="2">Instrumen Tugas</option>
                            <option value="3">Surat Tugas</option>
                            <option value="4">Surat Perjalanan Dinas</option>
                            <option value="5">Disposisi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-file-template">File Template</label>
                        <input type="file" id="input-file-template" class="form-control" name="file">
                    </div>
                    <div class="alert alert-info">
                        <b>Perhatian</b>
                        <p>Kosongkan kolom file apabila tidak akan mengganti file template</p>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        $('#form-surat-template').on('submit', (e) => {
            e.preventDefault()

            const body = new FormData(document.querySelector("#form-surat-template"))

            $.ajax({
                url: "<?= base_url('generate/save_template') ?>",
                method: "POST",
                data: body,
                processData: false,
                contentType: false,
                success: (data) => {
                    const res = JSON.parse(data)
                    Swal.fire(res.status, res.message, 'info').then(() => location.reload())
                },
                error: (err) => {
                    const data = JSON.parse(err.responseText)
                    Swal.fire(data.status, data.message, 'error')
                }
            })
        })
        $('#form-surat-template-edit').on('submit', (e) => {
            e.preventDefault()

            const body = new FormData(document.querySelector("#form-surat-template-edit"))
            // body.append('id', $('#hidden-id-template-edit').val());

            $.ajax({
                url: "<?= base_url('generate/save_template') ?>",
                method: "POST",
                data: body,
                processData: false,
                contentType: false,
                success: (data) => {
                    console.log(data)
                    Swal.fire(data.status, data.message, 'info').then(() => location.reload())
                },
                error: (err) => {
                    const data = JSON.parse(err.responseText)
                    Swal.fire(data.status, data.message, 'error')
                }
            })
        })
    })

    const fetchEdit = (nama_template, keterangan, jenis_template, id) => {
        console.log(id)
        $('#input-nama-template-edit').val(nama_template);
        $('#input-keterangan-template-edit').val(keterangan);
        $('#input-jenis-template-edit').val(jenis_template);
        $('#hidden-id-template-edit').val(id);
    }

    const beforeDelete = async (id) => {
        const result = await Swal.fire({
            title: "Apa anda yakin ?",
            showCancelButton: true,
            icon: "question",
            allowOutsideClick: false
        })

        if (result.isConfirmed == true) {
            const body = new FormData
            body.append('id', id)
            $.ajax({
                url: "<?= base_url('generate/delete_template') ?>",
                method: "POST",
                data: body,
                contentType: false,
                processData: false,
                success(data) {
                    const res = JSON.parse(data)
                    Swal.fire(res.status, res.message, 'info').then(() => location.reload())
                },
                error(err) {
                    const error = JSON.parse(err.responseText);
                    Swal.fire(error.status, error.message, 'error')
                }
            })
        }
    }
</script>