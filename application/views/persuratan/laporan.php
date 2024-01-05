<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

<?php


function tsmbk($kod)
{
    $awal = isset($_POST['awal']) ? $_POST['awal'] : date('Y-m-d');
    $akhir = isset($_POST['akhir']) ? $_POST['akhir'] : date('Y-m-d');
    $ci = get_instance();
    try {
        $_dsm = $ci->db->query("SELECT COUNT(id) AS total FROM surat_masuk WHERE kode_surat LIKE '$kod%' AND DATE(surat_masuk.tanggal_diterima) >= '$awal' AND DATE(surat_masuk.tanggal_diterima) <= '$akhir'")->row();
        return $_dsm->total;
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
}

function tskbk($kod)
{

    $awal = isset($_POST['awal']) ? $_POST['awal'] : date('Y-m-d');
    $akhir = isset($_POST['akhir']) ? $_POST['akhir'] : date('Y-m-d');
    $ci = get_instance();
    try {
        $_dsk = $ci->db->query("SELECT COUNT(id) AS total FROM surat_keluar WHERE kode_surat LIKE '$kod%' AND DATE(surat_keluar.tanggal_surat) >= '$awal' AND DATE(surat_keluar.tanggal_surat) <= '$akhir'")->row();
        return $_dsk->total;
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
}

function whereNotLike($kod)
{
    return "'$kod',";
}

function tsknotlike($notlike)
{
    $awal = isset($_POST['awal']) ? $_POST['awal'] : date('Y-m-d');
    $akhir = isset($_POST['akhir']) ? $_POST['akhir'] : date('Y-m-d');
    $ci = get_instance();
    try {
        $_dsk = $ci->db->query("SELECT COUNT(id) AS total FROM surat_keluar WHERE DATE(surat_keluar.tanggal_surat) >= '$awal' AND DATE(surat_keluar.tanggal_surat) <= '$akhir' AND LEFT(kode_surat, 2) NOT IN ($notlike 'YY');", TRUE)->row();
        return $_dsk->total;
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
}

function tsmnotlike($notlike)
{
    $awal = isset($_POST['awal']) ? $_POST['awal'] : date('Y-m-d');
    $akhir = isset($_POST['akhir']) ? $_POST['akhir'] : date('Y-m-d');
    $ci = get_instance();
    try {
        $_dsm = $ci->db->query("SELECT COUNT(id) AS total FROM surat_masuk WHERE DATE(surat_masuk.tanggal_diterima) >= '$awal' AND DATE(surat_masuk.tanggal_diterima) <= '$akhir' AND LEFT(kode_surat, 2) NOT IN ($notlike 'YY');", TRUE)->row();
        return $_dsm->total;
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
}


?>
<div class="content-wrapper container-fluid">
    <div class="page-heading">
        <h3>Kelola Surat</h3>
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
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pelaporan Surat</h5>
                    </div>
                    <div class="card-body">
                        <form class="col-lg-4" method="post" action="<?= base_url('surat/generate_laporan') ?>">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jenis Surat</label>
                                <select name="jenis_surat" required class="form-control">
                                    <option value="" selected disabled>Pilih Salah Satu</option>
                                    <option value="surat_masuk">Surat Masuk</option>
                                    <option value="surat_keluar">Surat Keluar</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kode Surat</label>
                                <input name="kode_surat" type="text" placeholder="Kosongkan apabila ingin melihat semua surat" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Periode Laporan</label>
                                <p>Berdasarkan Tanggal Surat</p>
                                <div class="input-group">
                                    <input type="date" class="form-control" required name="awal">
                                    <input type="date" class="form-control" required name="akhir">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan Surat Berdasarkan Kode</h5>
                    </div>
                    <div class="card-body">
                        <form class="col-lg-4" method="post" action="<?= base_url('surat/laporan') ?>">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Periode Laporan</label>
                                <p>Berdasarkan Tanggal Surat</p>
                                <div class="input-group">
                                    <input type="date" class="form-control" required name="awal">
                                    <input type="date" class="form-control" required name="akhir">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="<?= base_url('surat/laporan') ?>" class="btn btn-danger">Reset</a>
                        </form>
                        <hr>
                        <p>Total Semua Surat Masuk dan Keluar Berdasarkan Kode</p>
                        <table class="table table-bordered table-hovered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Surat Masuk</th>
                                    <th>Surat Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $notlike = ""; ?>
                                <?php foreach ($kode_surat as $k => $kv) { ?>
                                    <?php $notlike .= whereNotLike($kv->kode) ?>
                                    <tr>
                                        <td><?= ++$k ?></td>
                                        <td><?= $kv->kode ?></td>
                                        <td><?= tsmbk($kv->kode) ?></td>
                                        <td><?= tskbk($kv->kode) ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>11</td>
                                    <td>Lainnya</td>
                                    <td><?= tsmnotlike($notlike) ?></td>
                                    <td><?= tsknotlike($notlike) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>