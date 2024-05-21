<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

<?php


function tsmbk($kod)
{
	$bulan = ($_POST["bulan"]) ?? date("m");
	$tahun = $_POST["tahun"] ?? date("Y");
	$ci = get_instance();
	try {
		$_dsm = $ci->db->query("SELECT COUNT(id) AS total FROM surat_masuk WHERE kode_surat LIKE '$kod%' AND MONTH(surat_masuk.tanggal_diterima) = '$bulan' AND YEAR(surat_masuk.tanggal_diterima) = '$tahun'")->row();
		return $_dsm->total;
	} catch (\Throwable $th) {
		return $th->getMessage();
	}
}

function tskbk($kod)
{

	$bulan = ($_POST["bulan"]) ?? date("m");
	$tahun = $_POST["tahun"] ?? date("Y");
	$ci = get_instance();
	try {
		$_dsk = $ci->db->query("SELECT COUNT(id) AS total FROM surat_keluar WHERE kode_surat LIKE '$kod%' AND MONTH(surat_keluar.tanggal_surat) = '$bulan' AND YEAR(surat_keluar.tanggal_surat) = '$tahun'")->row();
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
	$bulan = ($_POST["bulan"]) ?? date("m");
	$tahun = $_POST["tahun"] ?? date("Y");
	$ci = get_instance();
	try {
		$_dsk = $ci->db->query("SELECT COUNT(id) AS total FROM surat_keluar WHERE MONTH(surat_keluar.tanggal_surat) = '$bulan' AND YEAR(surat_keluar.tanggal_surat) = '$tahun' AND LEFT(kode_surat, 2) NOT IN ($notlike 'YY');", TRUE)->row();
		return $_dsk->total;
	} catch (\Throwable $th) {
		return $th->getMessage();
	}
}

function tsmnotlike($notlike)
{
	$bulan = ($_POST["bulan"]) ?? date("m");
	$tahun = $_POST["tahun"] ?? date("Y");
	$ci = get_instance();
	try {
		$_dsm = $ci->db->query("SELECT COUNT(id) AS total FROM surat_masuk WHERE MONTH(surat_masuk.tanggal_diterima) = '$bulan' AND YEAR(surat_masuk.tanggal_diterima) = '$tahun' AND LEFT(kode_surat, 2) NOT IN ($notlike 'YY');", TRUE)->row();
		return $_dsm->total;
	} catch (\Throwable $th) {
		return $th->getMessage();
	}
}


?>
<div class="content-wrapper container">
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
			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Pelaporan Surat</h5>
					</div>
					<div class="card-body">
						<form class="col-lg-12" method="post" action="<?= base_url('surat/generate_laporan') ?>">
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
								<input name="kode_surat" type="text" placeholder="Kosongkan apabila ingin melihat semua surat" class="form-control" list="list-kode-surat">
								<datalist id="list-kode-surat">
									<?php foreach ($kode_surat as $k => $kv) { ?>
										<option><?= $kv->kode ?></option>
									<?php } ?>
								</datalist>
							</div>

							<div class="mb-3">
								<label for="exampleInputEmail1" class="form-label">Periode Laporan</label>
								<p>Berdasarkan Tanggal Surat</p>
								<div class="d-flex">
									<select name="bulan" required class="form-control form-control-select">
										<option value="" selected disabled>Pilih Bulan</option>
										<option value="1">Januari</option>
										<option value="2">Februari</option>
										<option value="3">Maret</option>
										<option value="4">April</option>
										<option value="5">Mei</option>
										<option value="6">Juni</option>
										<option value="7">Juli</option>
										<option value="8">Agustus</option>
										<option value="9">September</option>
										<option value="10">Oktober</option>
										<option value="11">November</option>
										<option value="12">Desember</option>
									</select>
									<select id="tahun" name="tahun" required class="form-control form-control-select">
										<option value="" selected disabled>Pilih Tahun</option>
										<?php
										// Menghitung tahun saat ini
										$tahunSekarang = date("Y");

										// Menampilkan opsi tahun dari 10 tahun yang lalu hingga 10 tahun ke depan
										for ($tahun = $tahunSekarang - 1; $tahun <= $tahunSekarang + 0; $tahun++) {
											echo "<option value=\"$tahun\">$tahun</option>";
										}
										?>
									</select>
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-6 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Laporan Surat Berdasarkan Kode</h5>
					</div>
					<div class="card-body">
						<form class="col-lg-12" method="post" action="<?= base_url('surat/laporan') ?>">
							<div class="mb-3">
								<label for="exampleInputEmail1" class="form-label">Periode Laporan</label>
								<p>Berdasarkan Tanggal Surat</p>
								<div class="d-flex">
									<select name="bulan" required class="form-control form-control-select">
										<option value="" selected disabled>Pilih Bulan</option>
										<option value="1">Januari</option>
										<option value="2">Februari</option>
										<option value="3">Maret</option>
										<option value="4">April</option>
										<option value="5">Mei</option>
										<option value="6">Juni</option>
										<option value="7">Juli</option>
										<option value="8">Agustus</option>
										<option value="9">September</option>
										<option value="10">Oktober</option>
										<option value="11">November</option>
										<option value="12">Desember</option>
									</select>
									<select id="tahun" name="tahun" required class="form-control form-control-select">
										<option value="" selected disabled>Pilih Tahun</option>
										<?php
										// Menghitung tahun saat ini
										$tahunSekarang = date("Y");

										// Menampilkan opsi tahun dari 10 tahun yang lalu hingga 10 tahun ke depan
										for ($tahun = $tahunSekarang - 1; $tahun <= $tahunSekarang + 0; $tahun++) {
											echo "<option value=\"$tahun\">$tahun</option>";
										}
										?>
									</select>
								</div>
								<br>
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