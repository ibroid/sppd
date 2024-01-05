<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Daftar Pejabat Pelaksana harian</h3>
	</div>
	<div class="page-content">
		<section class="section">
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
			<div class="card">
				<div class="card-body">
					<form action="<?= base_url('kepegawaian/plh') ?>" method="POST">
						<table>
							<tr>
								<th>
									<button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary">Referensi Pegawai</button>
								</th>
								<th width="400px">
									<input type="text" required class="form-control" id="nama" name="nama_pejabat" placeholder="Masukan Nama ...">
								</th>
								<th width="300px">
									<input type="text" required class="form-control" id="nip" name="nip_pejabat" placeholder="Masukan NIP ...">
								</th>
								<th width="300px">
									<input type="text" required class="form-control" id="jabatan" name="jabatan" placeholder="Masukan Jabatan ...">
								</th>
								<th>
									<button class="btn btn-success">Simpan</button>
								</th>
							</tr>
						</table>
					</form>
					<hr>
					<table id="daftar" class="table table-hover table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>NIP</th>
								<th>Jabatan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($plh as $n => $v) { ?>
								<tr>
									<td><?= ++$n ?></td>
									<td><?= $v->nama_pejabat ?></td>
									<td><?= $v->nip_pejabat ?></td>
									<td><?= $v->jabatan ?></td>
									<td><a href="<?= base_url('kepegawaian/hapus_plh/' . $v->id) ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
								</tr>
							<?php } ?>
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
				<h5 class="modal-title" id="staticBackdropLabel">Pegawai</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class="table" id="daftarPegawai">
					<thead>
						<tr>
							<th>Nama</th>
							<th>NIP</th>
							<th>Jabatan</th>
							<th>Golongan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($pegawai as $n => $v) { ?>
							<tr>
								<td><?= $v->nama ?></td>
								<td><?= $v->nip ?></td>
								<td><?= $v->jabatan->nama_jabatan ?></td>
								<td><?= $v->golongan->nama_golongan ?> (<?= $v->golongan->kode_golongan ?>)</td>
								<td>
									<button data-bs-dismiss="modal" data-json='<?= str_replace("'", "`", $v)  ?>' class="btn btn-warning btn-edit">Pilih</button>
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
		const dataTable = new simpleDatatables.DataTable("#daftar");
		const dataTablePegawai = new simpleDatatables.DataTable("#daftarPegawai");
		const editButtons = document.querySelectorAll('.btn-edit');
		for (let i = 0; i < editButtons.length; i++) {
			const editButton = editButtons[i];
			editButton.addEventListener('click', () => {

				const data = JSON.parse(editButton.dataset.json);
				$('#jabatan').val(data.jabatan.nama_jabatan);
				$('#nama').val(data.nama);
				$('#nip').val(data.nip);

			})
		}
	})
</script>