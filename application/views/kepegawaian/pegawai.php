<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Menu Pegawai</h3>
	</div>
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
		<section class="section">
			<div class="card">
				<div class="card-body">
					<h5>Form Input Pegawai Baru</h5>
					<form action="<?= base_url('kepegawaian/pegawai') ?>" method="POST">
						<input type="hidden" id="pegawai_id" name="id">
						<table>
							<tr>
								<th width="400px"><input id="nama" required type="text" name="nama" class="form-control" placeholder="Masukan Nama .."></th>
								<th width="300px"><input id="nip" required type="number" name="nip" class="form-control" placeholder="Masukan NIP .."></th>
								<th width="300px">
									<select name="jabatan_id" id="jabatan" class="form-control">
										<option selected disabled value="">Pilih Jabatan ..</option>
										<?php foreach ($jabatan as $j) { ?>
											<option value="<?= $j->id ?>"><?= $j->nama_jabatan ?></option>
										<?php } ?>
									</select>
								</th>
								<th width="300px">
									<select name="golongan_id" id="golongan" class="form-control">
										<option selected disabled value="">Pilih Golongan ..</option>
										<?php foreach ($golongan as $gs) { ?>
											<option value="<?= $gs->id ?>"><?= $gs->nama_golongan ?> (<?= $gs->kode_golongan ?>)</option>
										<?php } ?>
									</select>
								</th>
								<th width="300px"><input id="nomor_telepon" required type="number" name="nomor_telepon" class="form-control" placeholder="No Wa. Diawali 62 (62812XX)"></th>
								<th width="200px"><button class="btn btn-success btn-block">Simpan</button></th>
							</tr>
						</table>
						<p class="mt-2 text-primary">Masukan 0 Pada kolom NIP apabila input data pegawai non asn</p>
						<p class="text-danger">Apabila ada pegawai yang status jabatan nya "seorang". Maka data pegawai tersebut akan terhapus apabila ada pegawai baru dengan jabatan yang sama</p>
					</form>
					<hr>
					<h5>Daftar Pegawai</h5>
					<table id="daftar" class="table table-hover table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>NIP</th>
								<th>Jabatan</th>
								<th>Pangkat Golongan</th>
								<th>Nomor Telepon</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $n => $v) { ?>
								<tr>
									<td><?= ++$n ?></td>
									<td><?= $v->nama ?></td>
									<td><?= $v->nip ?></td>
									<td><?= $v->jabatan->nama_jabatan ?> (<?= $v->jabatan->single == 1 ? 'Seorang' : 'Jamak' ?>)</td>
									<td><?= $v->golongan->nama_golongan ?> (<?= $v->golongan->kode_golongan ?>)</td>
									<td><?= $v->nomor_telepon ?></td>
									<td>
										<button data-json='<?= $v ?>' class="btn btn-warning btn-edit">
											<i class="bi bi-pencil"></i>
										</button>
										<button onclick="hapusPegawai('<?= $v->id ?>')" class="btn btn-danger"><i class="bi bi-trash"></i></button>
									</td>
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
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Understood</button>
			</div>
		</div>
	</div>
</div>
<script>
	const hapusPegawai = async (id) => {
		const dcsion = await Swal.fire({
			title: 'Yakin ?',
			allowOutsideClick: false,
			backdrop: true,
			showCancelButton: true
		})

		if (dcsion.isConfirmed) {
			location.href = "<?= base_url('kepegawaian/hapus_pegawai/') ?>" + id;
		}
	}
	$(document).ready(() => {
		const dataTable = new simpleDatatables.DataTable("#daftar", {
			"initComplete": () => console.log('ok')
		});

		dataTable.on('datatable.search', () => {
			console.log('datatable search')
			setButnEdit()
		});

		dataTable.on('datatable.page', () => {
			console.log('datatable page')
			setButnEdit()
		});

		dataTable.on('datatable.init', () => {
			console.log('datatable init')
			setButnEdit()
		});

		function setButnEdit() {
			const editButtons = document.querySelectorAll('.btn-edit');
			for (let i = 0; i < editButtons.length; i++) {
				const editButton = editButtons[i];
				editButton.addEventListener('click', () => {

					const data = JSON.parse(editButton.dataset.json);
					$('#jabatan').val(data.jabatan_id);
					$('#golongan').val(data.golongan_id);
					$('#nama').val(data.nama);
					$('#nip').val(data.nip);
					$('#nomor_telepon').val(data.nomor_telepon);
					$('#pegawai_id').val(data.id);
				})
			}
		}
	})
</script>