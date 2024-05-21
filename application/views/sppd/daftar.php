<div class="content-wrapper container">
	<div class="page-heading">
		<h2>Daftar Surat Perjalanan Dinas</h2>
	</div>
	<div class="page-body">
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
		<section class="section">
			<div class="card">
				<div class="card-body">
					<form action="" method="post">
						<div class="row">
							<div class="form-group col-md-4">
								<label for="tanggal">Cari Berdasarkan Tanggal Buat</label>
								<input type="date" class="form-control" name="tanggal">
							</div>
							<div class="form-group col-md-2">
								<button class="btn btn-primary mt-4">Cari Data</button>
							</div>
						</div>
					</form>
					<table id="tableSuratDinas" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Berangkat</th>
								<th>Pulang</th>
								<th>Biaya</th>
								<th>Pegawai</th>
								<th>Nomor Surat</th>
								<th>Print</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Print</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" method="POST" id="formPenandatangan">
					<label for="template">Pilih Penanda Tangan</label>
					<div class="input-group mb-3">
						<select class="form-control" name="penandatangan" aria-describedby="button-addon4">
							<option value="Ketua" selected>Ketua (Default)</option>
							<option>Wakil</option>
							<option>Panitera</option>
							<option>Sekretaris</option>
							<?php foreach ($plh as $p) { ?>
								<option value="<?= $p->id ?>">(PLH) <?= $p->nama_pejabat ?></option>
							<?php } ?>
						</select>
						<button class="btn btn-success mt-4" id="button-addon4">Simpan</button>
					</div>
				</form>
				<form id="formTanggalPencairan" method="POST">
					<label for="tanggal_pencairan">Tetapkan Tanggal Pencairan</label>
					<div class="input-group mb-3">
						<input type="hidden" name="sppd_id" id="inputsppd">
						<input id="tglpencairan" type="date" class="form-control" name="tanggal_pencairan" aria-label="Recipient's username" aria-describedby="button-addon2">
						<button class="btn btn-success" type="submit" id="button-addon2">Tetapkan</button>
					</div>
					<small id="tglAlertText" class="text-danger">Tanggal Pencairan Masih Kosong</small>
				</form>
				<table class="table">
					<thead>
						<tr>
							<th>Nama</th>
							<th>SPD</th>
							<th>SPPD</th>
							<th>Rincian Biaya</th>
							<th>Kwitansi</th>
							<th>Penggunaan Riil</th>
						</tr>
					</thead>
					<tbody id="tbodyPegawai">

					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(() => {

		$('#tableSuratDinas').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
			},
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": '<?= base_url('sppd/datatable') ?>',
				"type": "POST"
			},
			"drawCallback": () => {

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

				$('#formTanggalPencairan').on('submit', async (e) => {
					e.preventDefault();
					const body = new FormData
					Swal.showLoading();
					body.append('tanggal_pencairan', $('#tglpencairan').val());
					body.append('id', $('#inputsppd').val());
					const postReq = await fetch('<?= base_url('sppd/tanggal_pencairan') ?>', {
							method: 'POST',
							body
						})
						.then(res => res.json())
					$('#tglAlertText').remove()
					Swal.close();
					Swal.fire("Tanggal Pencairan Berhasil Ditetapkan");
					console.log(postReq);
				})

				var exampleModal = document.getElementById('staticBackdrop')
				exampleModal.addEventListener('show.bs.modal', function(event) {
					var button = event.relatedTarget
					var recipient = JSON.parse(button.getAttribute('data-bs-pegawai'))
					console.log(recipient)
					let el = '';
					$('#inputsppd').val(recipient.id)
					if (recipient.tanggal_pencairan) {
						$('#tglpencairan').val(recipient.tanggal_pencairan)
						$('#tglAlertText').remove()
					}
					// console.log(recipient)
					recipient.surat_tugas.pegawai.forEach(element => {
						el += `	<tr >
							<td>${element.nama}</td>
							<td><a href="<?= base_url('cetak/spd/') ?>${element.surat_tugas_id}/${element.id}" class="btn btn-sm btn-danger"><i class="bi bi-printer"></i></a></td>
							<td><a href="<?= base_url('cetak/sppd/') ?>${element.surat_tugas_id}/${element.id}" class="btn btn-sm btn-danger"><i class="bi bi-printer"></i></a></td>
							<td><a href="<?= base_url('cetak/rincian_kwitansi/') ?>${element.surat_tugas_id}/${element.id}" class="btn btn-sm btn-danger"><i class="bi bi-printer"></i></a></td>
							<td><a href="<?= base_url('cetak/kwitansi/') ?>${element.surat_tugas_id}/${element.id}" class="btn btn-sm btn-danger"><i class="bi bi-printer"></i></a></td>
							<td><a href="<?= base_url('cetak/riil/') ?>${element.surat_tugas_id}/${element.id}" class="btn btn-sm btn-danger"><i class="bi bi-printer"></i></a></td>
						</tr>`
					});
					$('#tbodyPegawai').html(el)
				})

			}
		});




		// const dataTable = new simpleDatatables.DataTable("#daftar");


	})

	const hapusData = (id) => {
		Swal.fire({
			title: 'Apa anda yakin ?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			showLoaderOnConfirm: true,
			backdrop: true,
			allowOutsideClick: () => !Swal.isLoading(),
			preConfirm: () => {
				const body = new FormData()
				body.append('id', id)
				return fetch(`<?= base_url('sppd/hapus') ?>`, {
						method: 'POST',
						body: body
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
</script>