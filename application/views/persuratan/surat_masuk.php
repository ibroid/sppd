<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

<div class="content-wrapper container-fluid">
	<div class="page-heading">
		<h3>Kelola Surat Masuk</h3>
	</div>
	<div class="page-content ">
		<?php if ($this->session->flashdata('notif') or $this->session->flashdata('notif_file')) { ?>
			<div class="alert alert-info">
				<strong>
					<?= $this->session->flashdata('notif') ?><br>
					<?= $this->session->flashdata('notif_file') ?>
					<?= $this->session->flashdata('wa_res_notif') ?>
				</strong>
			</div>
		<?php } ?>
		<?php if (pengaturan()->maintenance == 1) { ?>
			<div class="alert alert-danger">
				<strong>
					MAINTENANCE. TOLONG JANGAN DI PAKAI
				</strong>
			</div>
		<?php } ?>
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Kontrol Surat Masuk</h5>
			</div>
			<div class="card-body">
				<ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Tambah</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" tabindex="-1">Disposisi</a>
					</li>
				</ul>

				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
						<h6>Cari Berdasarkan Periode Tanggal Diterima</h6>
						<form action="<?= base_url('surat/surat_masuk') ?>" method="POST">
							<div class="row">
								<div class="col-md-3">
									<div class="input-group mb-3">
										<input type="date" class="form-control" name="awal">
										<input type="date" class="form-control" name="akhir">
										<button class="btn btn-primary" type="submit" id="button-addon2">Cari</button>
										<a class="btn btn-outline-danger" href="<?= base_url('/surat/surat_masuk') ?>" id="button-addon2">reset</a>
									</div>
								</div>
							</div>
						</form>
						<p class="my-2">
						<h6>Tabel Surat Masuk</h6>
						<table id="tableSuratMasuk" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Nomor Register</th>
									<th>Asal Surat</th>
									<th>Nomor Surat</th>
									<th>Tanggal Surat</th>
									<th>Perihal</th>
									<th>Tanggal Diterima</th>
									<th>Disposisi</th>
									<th>File</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

							</tbody>

						</table>
						</p>
					</div>
					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<h6 class="text-center">Form Tambah Surat Masuk</h6>
						<form autocomplete="off" onsubmit="Swal.fire({
                                title: 'Mohon Tunggu',
                                willOpen: () => Swal.showLoading(),
                                backdrop: true,
                                allowOutsideClick: false,
                                showConfirmButton: false })" action="<?= base_url('/surat/save_surat_masuk') ?>" method="post" enctype="multipart/form-data" class="form form-horizontal">
							<div class="form-body">
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="align-right">Asal Surat <i class="text-danger inline">*</i></label>
									</div>
									<div class="col-md-7 form-group">
										<input type="text" id="input-asal-surat" class="form-control" name="asal" placeholder="Asal Surat : Wajib Di Isi" required>
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="text-end">Nomor Surat <i class="text-danger inline">*</i></label>
									</div>
									<div class="col-md-7 form-group">
										<input id="add-input-nomor-surat" type="text" class="form-control" name="nomor_surat" placeholder="Nomor Surat : Wajib Di Isi" required>
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="text-end">Kode Surat</label>
									</div>
									<div class="col-md-7 form-group">
										<input type="text" class="form-control" name="kode_surat" placeholder="Kode Surat">
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="text-end">Tanggal Surat <i class="text-danger inline">*</i></label>
									</div>
									<div class="col-md-7 form-group">
										<input type="date" class="form-control" name="tanggal_surat" placeholder="Tanggal Surat : Wajib Di Isi" required>
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="text-end">Tanggal Diterima <i class="text-danger inline">*</i></label>
									</div>
									<div class="col-md-7 form-group">
										<input type="date" class="form-control" name="tanggal_diterima" placeholder="Tanggal Diterima : Wajib Di Isi" required value="<?= date('Y-m-d') ?>">
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="text-end">Perihal</label>
									</div>
									<div class="col-md-7 form-group">
										<input type="text" class="form-control" name="perihal" placeholder="Perihal">
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="text-end">Ringkasan Isi</label>
									</div>
									<div class="col-md-7 form-group">
										<textarea name="ringkasan_isi" class="form-control" cols="5" rows="3"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="text-end">Catatan</label>
									</div>
									<div class="col-md-7 form-group">
										<input type="text" class="form-control" name="catatan" placeholder="Catatan">
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<label class="text-end">File Dokumen</label>
									</div>
									<div class="col-md-7 form-group">
										<input type="file" class="form-control" name="file">
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
										<div class="alert alert-light-warning color-warning">
											<i class="bi bi-exclamation-triangle"></i> Apabila terdapat nomor surat dan tanggal surat yang sama dengan data yang telah di input sebelumnya. Maka data sebelumnya akan diperbarui tanpa menambah data yang baru.
										</div>
									</div>

								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
						<h6>Tabel Disposisi</h6>
						<table id="tableDisposisi" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Asal</th>
									<th>Nomor Surat</th>
									<th>Tanggal Surat</th>
									<th>Perihal</th>
									<th>Pegawai</th>
									<th>Isi Disposisi</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="8" class="text-center">Mohon Tunggu Sebentar ...</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-warning">
				<h5 class="modal-title text-light" id="modalTitleId">Edit Data Surat Masuk</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form autocomplete="off" onsubmit="Swal.fire({
                                title: 'Mohon Tunggu',
                                willOpen: () => Swal.showLoading(),
                                backdrop: true,
                                allowOutsideClick: false,
                                showConfirmButton: false })" action="<?= base_url('/surat/update_surat_masuk') ?>" method="post" enctype="multipart/form-data" class="form form-horizontal">
					<input type="hidden" id="hidden-surat-id" name="id">
					<div class="form-body">
						<div class="row">
							<div class="col-md-1">
							</div>
							<div class="col-md-3">
								<label class="align-right">Asal Surat <i class="text-danger inline">*</i></label>
							</div>
							<div class="col-md-7 form-group">
								<input type="text" id="edit-input-asal-surat" class="form-control" name="asal" placeholder="Asal Surat : Wajib Di Isi" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-1">
							</div>
							<div class="col-md-3">
								<label class="text-end">Nomor Surat <i class="text-danger inline">*</i></label>
							</div>
							<div class="col-md-7 form-group">
								<input type="text" id="input-nomor-surat" class="form-control" name="nomor_surat" placeholder="Nomor Surat : Wajib Di Isi" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-1">
							</div>
							<div class="col-md-3">
								<label class="text-end">Kode Surat</label>
							</div>
							<div class="col-md-7 form-group">
								<input type="text" id="input-kode-surat" class="form-control" name="kode_surat" placeholder="Kode Surat">
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
								<label class="text-end">Tanggal Diterima <i class="text-danger inline">*</i></label>
							</div>
							<div class="col-md-7 form-group">
								<input type="date" id="input-tanggal-diterima" class="form-control" name="tanggal_diterima" placeholder="Tanggal Diterima : Wajib Di Isi" required value="<?= date('Y-m-d') ?>">
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


<div class="modal" id="modalDisposisi" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-success">
				<h5 class="modal-title text-light" id="modalTitleId"><i class="bi bi-person-plus-fill"></i> Disposisi Surat</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="form form-horizontal" id="form-disposisi" method="POST" action="<?= base_url('surat/disposisi') ?>">
					<input type="hidden" id="input-hidden-surat-masuk-id" name="surat_masuk_id">
					<input type="hidden" id="input-hidden-pegawai-id" name="pegawai_id">
					<div class="form-body">
						<div class="row">
							<div class="col-md-4">
								<label>Pegawai</label>
							</div>
							<div class="col-md-8 form-group">
								<input type="text" required id="input-pegawai" class="form-control" placeholder="Nama Pegawai">
							</div>
							<div class="col-md-4">
								<label>Nomor Index</label>
							</div>
							<div class="col-md-8 form-group">
								<input type="number" required id="input-nomor-index" class="form-control" name="nomor_index" placeholder="Nomor Index">
							</div>
							<div class="col-md-4">
								<label>Isi Disposisi</label>
							</div>
							<div class="col-md-8 form-group">
								<textarea name="isi_disposisi" class="form-control" id="textarea-isi-disposisi" cols="5" rows="3"></textarea>
							</div>
							<div class="col-sm-12 d-flex justify-content-end">
								<button type="submit" class="btn btn-primary me-1 mb-1">
									Simpan
								</button>
								<button type="reset" class="btn btn-light-secondary me-1 mb-1">
									Reset
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modalLihatDisposisi" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-ligth" id="modalTitleId">Disposisi Surat</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered ">
					<thead>
						<tr>
							<th>Pegawai</th>
							<th>Nomor Agenda</th>
							<th>Isi Disposisi</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody id="tbody-disposisi">

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="modalEditNrt" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-ligth" id="modalTitleId">Ubah Nomor Register</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('/surat/update_no_register') ?>" method="post">
					<label for="input-nrt">ID</label>
					<input id="input-id-surat" type="number" name="id" readonly class="form-control">
					<label for="input-nrt">Nomor Register</label>
					<input id="input-nrt" type="number" class="form-control" name="nomor_register">
					<hr>
					<button class="btn btn-sm btn-success">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>



<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/js/autocomplete.js') ?>"></script>
<script>
	var editModal = null;
	var disposModal = null;
	var lihatDisposModal = null;
	var tableDisposisi = null;
	$(document).ready(() => {
		editModal = new bootstrap.Modal(document.getElementById('modalId'))
		disposModal = new bootstrap.Modal(document.getElementById('modalDisposisi'))
		lihatDisposModal = new bootstrap.Modal(document.getElementById('modalLihatDisposisi'))

		const ac = new Autocomplete(document.getElementById('input-asal-surat'), {
			data: JSON.parse('<?= json_encode($suggest_asal_surat)  ?>'),
			maximumItems: 10,
		});

		const ad = new Autocomplete(document.getElementById('edit-input-asal-surat'), {
			data: JSON.parse('<?= json_encode($suggest_asal_surat)  ?>'),
			maximumItems: 10,
		});

		const an = new Autocomplete(document.getElementById('add-input-nomor-surat'), {
			data: JSON.parse('<?= json_encode($suggest_nomor_surat)  ?>'),
			maximumItems: 10,
		});

		const ap = new Autocomplete(document.getElementById('input-pegawai'), {
			data: JSON.parse('<?= json_encode($suggest_pegawai)  ?>'),
			maximumItems: 10,
			onSelectItem: ({
				label,
				value
			}) => $('#input-hidden-pegawai-id').val(value)
		});

		$('#tableSuratMasuk').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
			},
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				//panggil method ajax list dengan ajax
				"url": '<?= base_url('surat/datatable_surat_masuk') ?>',
				"type": "POST"
			}
		});

		$('#contact-tab').click(() => {

			if (tableDisposisi == null) {

				setTimeout(() => {
					tableDisposisi = $('#tableDisposisi').DataTable({
						"language": {
							"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
						},
						"processing": true,
						"serverSide": true,
						"order": [],
						"ajax": {
							//panggil method ajax list dengan ajax
							"url": '<?= base_url('surat/datatable_disposisi') ?>',
							"type": "POST"
						}
					});

				}, 1000)


			}
		})

		$('#form-disposisi').on('submit', (e) => {
			e.preventDefault()
			console.log($('#input-hidden-pegawai-id').val())
			if ($('#input-hidden-pegawai-id').val() == '') {
				Swal.fire('null')
			} else {
				document.getElementById('form-disposisi').submit()
			}
		})
	})

	const uploadFile = async (id) => {
		Swal.fire({
			title: 'Pilih Dokumen Surat Masuk',
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
				return fetch(`<?= base_url('surat/update_surat_masuk') ?>`, {
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
		$('#edit-input-asal-surat').val(data.asal)
		$('#input-nomor-surat').val(data.nomor_surat)
		$('#input-tanggal-surat').val(data.tanggal_surat)
		$('#input-kode-surat').val(data.kode_surat)
		$('#input-tanggal-diterima').val(data.tanggal_diterima)
		$('#input-perihal').val(data.perihal)
		$('#textarea-ringkasan-isi').val(data.ringkasan_isi)
		$('#input-catatan').val(data.catatan)
		editModal.show()
	}

	const deleteData = (id) => {
		Swal.fire({
			title: 'Apa anda yakin ?',
			icon: 'question',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			showLoaderOnConfirm: true,
			preConfirm: (value) => {
				//login is your inputed data
				const body = new FormData()
				body.append('id', id)
				return fetch(`<?= base_url('surat/hapus_surat_masuk') ?>`, {
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

	const disposisi = (id) => {
		$('#input-hidden-surat-masuk-id').val(id)
		lihatDisposModal.hide()
		disposModal.show()
	}

	const lihatDisposisi = async (id) => {
		Swal.fire({
			title: 'Mohon Tunggu',
			willOpen: () => Swal.showLoading(),
			backdrop: true,
			allowOutsideClick: false,
			showConfirmButton: false
		})

		const disposisi = await fetch('<?= base_url('surat/lihat_disposisi/') ?>' + id)
			.then(res => {
				if (!res.ok) {
					throw new Error(res.statusText)
				}
				return res.json()
			})
			.then(res => res)
			.catch(err => Swal.fire('Terjadi Kesalahan', err.message, 'error'))

		if (disposisi) {
			let el = ''
			disposisi.forEach((row, i) => {
				el += '<tr>';
				el += `<td>${row.pegawai.nama}</td>`;
				el += `<td>${row.nomor_agenda}</td>`;
				el += `<td>${row.isi_disposisi}</td>`;
				el += `<td><a target="_blank" href="${'<?= base_url('cetak/disposisi/') ?>' + row.id}" class="btn btn-sm btn-primary">Cetak</a><a href="${'<?= base_url('surat/hapus_disposisi/') ?>' + row.id}" class="btn btn-sm btn-danger">Hapus</a></td>`;
				el += '</tr>';
			})
			el += `<tr><td colspan="4" class="text-center"><a href="javascript:void(0)" onclick="disposisi(${id})" class="btn btn-sm icon-left btn-success">Tambah Disposisi</a></td></tr>`;
			$('#tbody-disposisi').html(el)
			lihatDisposModal.show()
			Swal.close()
		}


	}

	const fetchUbahNrt = (id) => {
		$('#input-id-surat').val(id)
	}
</script>