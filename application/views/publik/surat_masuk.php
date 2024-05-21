<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manajemen dan Sistem Suart</title>
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/favicon') ?>/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon') ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon') ?>/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url('assets/favicon') ?>/site.webmanifest">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css"> -->
	<link rel="stylesheet" href="<?= base_url() ?>/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/iconly/bold.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css">


	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script src="<?= base_url('assets/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>
</head>

<body>
	<div id="app">
		<div id="main" class="layout-horizontal">
			<header class="mb-4">

			</header>

			<div class="content-wrapper">
				<div class="page-heading text-center">
					<h3>Kirim Surat Untuk <?= pengaturan()->nama_satker ?></h3>
				</div>
				<div class="d-flex justify-content-center">
					<div class="page-content">
						<?php if ($this->session->flashdata('notif') or $this->session->flashdata('notif_file')) { ?>
							<div class="alert alert-info">
								<strong>
									<?= $this->session->flashdata('notif') ?><br>
									<?= $this->session->flashdata('notif_file') ?>
								</strong>
							</div>
						<?php } ?>
						<?php if (pengaturan()->maintenance == 1) { ?>
							<div class="alert alert-danger">
								<strong>
									MOHON MAAF. SAAT INI LAYANAN PENGIRIMAN SURAT SEDANG MAINTENANCE.
								</strong>
							</div>
							<div class="alert alert-info">
								<strong>
									UNTUK ALTERNATIF SILAHKAN KIRIM KE EMAIL KAMI DI <?= pengaturan()->email_satker ?>
								</strong>
							</div>
						<?php } else { ?>
							<?php if (!$this->session->userdata('nama_iden_publik')) { ?>
								<div class="card">
									<div class="card-header">
										<h5 class="card-title">Input Identitas Anda Pengirim</h5>
									</div>
									<div class="card-body">
										<h6 class="text-center">Form Identitas</h6>
										<form autocomplete="off" id="form-identitas-pengirim" action="<?= base_url('/publik/save_identitas') ?>" method="post" enctype="multipart/form-data" class="form form-horizontal">
											<div class="form-body">
												<label class="align-right">Nama Lengkap / Nama Instansi <i class="text-danger inline">*</i></label>
												<input type="text" id="input-asal-surat" class="form-control" name="nama" placeholder="Nama Anda / Nama Instansi" maxlength="124" required>
												<br>

												<label class="align-right">Nomor telepon (WA/Rumah) yang bisa dihubungi <i class="text-danger inline">*</i></label>
												<input type="number" maxlength="20" id="input-asal-surat" class="form-control" name="nomor_telepon" placeholder="Nomor Telepon" required>

												<br>
												<button type="button" onclick="periksaLagi()" class="btn btn-primary me-1 mb-1">
													Simpan
												</button>
												<div class="alert alert-light-danger color-danger mt-3">
													<i class="bi bi-exclamation-circle"></i> Form dengan tanda bintang merah wajib diisi
												</div>
											</div>
										</form>
									</div>
								</div>
							<?php } ?>
							<div class="card">
								<div class="card-header">
									<h5 class="card-title">Input Data Surat Anda</h5>
								</div>
								<?php if ($this->session->userdata('nama_iden_publik')) { ?>
									<div class="card-body">
										<h6 class="text-center">Form Tambah Surat Masuk</h6>
										<form autocomplete="off" id="form-surat-masuk" action="<?= base_url('/publik/save_surat_masuk') ?>" method="post" enctype="multipart/form-data" class="form form-horizontal">
											<div class="form-body">
												<div class="row">

													<div class="col-md-4">
														<label>Asal Surat <i class="text-danger inline">*</i></label>
													</div>
													<div class="col-md-8 form-group">
														<input type="text" id="input-asal-surat" class="form-control" name="asal" placeholder="Asal Surat : Wajib Di Isi" required>
													</div>
												</div>
												<div class="row">

													<div class="col-md-4">
														<label>Nomor Surat <i class="text-danger inline">*</i></label>
													</div>
													<div class="col-md-8 form-group">
														<input type="text" class="form-control" name="nomor_surat" placeholder="Nomor Surat : Wajib Di Isi" required>
													</div>
												</div>
												<div class="row">

													<div class="col-md-4">
														<label>Kode Surat</label>
													</div>
													<div class="col-md-8 form-group">
														<input type="text" class="form-control" name="kode_surat" placeholder="Kode Surat">
													</div>
												</div>
												<div class="row">

													<div class="col-md-4">
														<label>Tanggal Surat <i class="text-danger inline">*</i></label>
													</div>
													<div class="col-md-8 form-group">
														<input type="date" class="form-control" name="tanggal_surat" placeholder="Tanggal Surat : Wajib Di Isi" required>
													</div>
												</div>
												<div class="row">

													<div class="col-md-4">
														<label>Tanggal Dikirim <i class="text-danger inline">*</i></label>
													</div>
													<div class="col-md-8 form-group">
														<input type="date" class="form-control" name="tanggal_diterima" placeholder="Tanggal Diterima : Wajib Di Isi" required value="<?= date('Y-m-d') ?>">
													</div>
												</div>
												<div class="row">

													<div class="col-md-4">
														<label>Perihal</label>
													</div>
													<div class="col-md-8 form-group">
														<input type="text" class="form-control" name="perihal" placeholder="Perihal">
													</div>
												</div>
												<div class="row">

													<div class="col-md-4">
														<label>Ringkasan Isi</label>
													</div>
													<div class="col-md-8 form-group">
														<textarea name="ringkasan_isi" class="form-control" cols="5" rows="3"></textarea>
													</div>
												</div>
												<div class="row">

													<div class="col-md-4">
														<label>Catatan</label>
													</div>
													<div class="col-md-8 form-group">
														<input type="text" class="form-control" name="catatan" placeholder="Catatan">
													</div>
												</div>
												<div class="row">

													<div class="col-md-4">
														<label>File Dokumen</label>
													</div>
													<div class="col-md-8 form-group">
														<input required type="file" class="form-control" name="file">
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-sm-12 d-flex justify-content-center">
														<button type="submit" class="btn btn-primary me-1 mb-1">
															Simpan
														</button>
														<a href="<?= base_url('/publik/reset') ?>" class="btn btn-light-secondary me-1 mb-1">
															Reset
														</a>
													</div>
												</div>

												<div class="alert alert-light-danger color-danger">
													<i class="bi bi-exclamation-circle"></i> Form dengan tanda bintang merah wajib diisi
												</div>
											</div>
										</form>
									</div>
								<?php } else { ?>
									<div class="alert alert-light-info color-info mt-3">
										<i class="bi bi-exclamation-circle"></i> Form Surat akan muncul setelah mengisi identitas pengirim di atas
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<footer>
				<div class="container">
					<div class="footer clearfix mb-0 text-muted">
						<div class="float-start">
							<p>2021 &copy; <?= pengaturan()->nama_satker ?></p>
						</div>
						<div class="float-end">
							<p>Created with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a target="_blank" href="https://mmaliki.my.id">Maliki</a></p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/js/pages/horizontal-layout.js"></script>
	<script>
		const periksaLagi = (e) => {
			Swal.fire({
				icon: 'info',
				title: 'Apa data yang masukan sudah sesuai ?',
				showCancelButton: true,
				confirmButtonText: 'Sudah',
				cancelButtonText: 'Periksa lagi'
			}).then(({
				isConfirmed
			}) => {
				if (isConfirmed) {
					Swal.fire({
						title: 'Mohon Tunggu',
						willOpen: () => Swal.showLoading(),
						backdrop: true,
						allowOutsideClick: false,
						showConfirmButton: false
					})

					$("#form-identitas-pengirim").submit()
				}

			})
		}

		$(document).ready(() => {
			$("#form-surat-masuk").on('submit', (e) => {

				e.preventDefault()
				Swal.fire({
					title: 'Mohon Tunggu',
					willOpen: () => Swal.showLoading(),
					backdrop: true,
					allowOutsideClick: false,
					showConfirmButton: false
				})

				const body = new FormData(document.querySelector('#form-surat-masuk'));

				$.ajax({
					url: "<?= base_url('/publik/simpan') ?>",
					method: "POST",
					data: body,
					contentType: false,
					processData: false,
					success(data) {
						data = JSON.parse(data)
						Swal.fire({
								title: data.status,
								text: data.message,
								icon: 'success',
								allowOutsideClick: true,
								backdrop: true
							})
							.then(() => {
								location.href = "<?= base_url('publik/reset') ?>"
							})
					},
					error(err) {
						const errResponse = JSON.parse(err.responseText);
						Swal.fire(errResponse.status, JSON.stringify(errResponse.message), 'error')
					}
				})

			})
		})
	</script>

</body>

</html>