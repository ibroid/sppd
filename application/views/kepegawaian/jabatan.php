<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Master Jabatan</h3>
	</div>
	<div class="page-content">
		<section class="section">
			<form action="" method="POST">
				<input type="hidden" id="jabatan_id" name="id">
				<table>
					<thead>
						<tr>
							<th width="400px">
								<input type="text" required id="nama" name="nama_jabatan" class="form-control" placeholder="Masukan Nama Jabatan ..">
							</th>
							<th width="400">
								<select name="atasan_langsung" id="atasan" required class="form-control">
									<option value="" selected disabled>Pilih Atasan Langsung ..</option>
									<?php foreach ($data as $n => $v) { ?>
										<option value="<?= $v->id ?>"><?= $v->nama_jabatan ?></option>
									<?php } ?>
								</select>
							</th>
							<th width="400px">
								<select name="atasan_pemberi_izin" id="jabatan" required class="form-control">
									<option value="" selected disabled>Pilih Pejabat Pemberi Izin ..</option>
									<?php foreach ($data as $n => $v) { ?>
										<option value="<?= $v->id ?>"><?= $v->nama_jabatan ?></option>
									<?php } ?>
								</select>
							</th>
							<th width="400px">
								<select name="single" id="single" required class="form-control">
									<option selected disabled>Posisi Jabatan</option>
									<option value="1">Seorang</option>
									<option value="0">Jamak</option>
								</select>
							</th>
							<th>
								<button class="btn btn-success">Simpan</button>
							</th>
						</tr>
					</thead>
				</table>
				<p class="mt-2 text-primary">Apabila Posisi jabatan di isi "Seorang". Maka hanya ada satu pegawai saja yang mempunyai status jabatan tersebut.</p>
			</form>
			<hr>
			<div class="card">
				<div class="card-body">

					<table id="daftar" class="table table-hover table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th width="300px">Jabatan</th>
								<th width="300px">Atasan</th>
								<th>Pejabat Pemberi Izin</th>
								<th>Single</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $n => $v) { ?>
								<tr>
									<td><?= ++$n ?></td>
									<td><?= $v->nama_jabatan ?></td>
									<td><?= $v->atasan->nama_jabatan ?></td>
									<td><?= $v->pejabat->nama_jabatan ?></td>
									<td><?= $v->single == 1 ? 'Seorang' : 'Jamak' ?></td>
									<td>
										<button data-json='<?= $v ?>' class="btn btn-sm btn-warning btn-edit"><i class="bi bi-pencil"></i></button>
										<a href="<?= base_url('kepegawaian/hapus_jabatan/' . $v->id) ?>" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i></a>
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
<script>
	// console.log('asdjasiodjiaso')
	$(document).ready(() => {

		const dataTable = new simpleDatatables.DataTable("#daftar");
		dataTable.on('datatable.page', function(page) {

			const editButtons = document.querySelectorAll('.btn-edit');
			for (let i = 0; i < editButtons.length; i++) {
				const editButton = editButtons[i];
				editButton.addEventListener('click', () => {

					const data = JSON.parse(editButton.dataset.json);
					$('#nama').val(data.nama_jabatan);
					$('#atasan').val(data.atasan_langsung);
					$('#jabatan').val(data.atasan_pemberi_izin);

				})
			}
		});

		const editButtons = document.querySelectorAll('.btn-edit');
		for (let i = 0; i < editButtons.length; i++) {
			const editButton = editButtons[i];
			editButton.addEventListener('click', () => {

				const data = JSON.parse(editButton.dataset.json);
				$('#nama').val(data.nama_jabatan);
				$('#atasan').val(data.atasan_langsung);
				$('#jabatan').val(data.atasan_pemberi_izin);

			})
		}

		// $('.btn.btn-sm.btn-warning.btn-edit').on('click', () => {
		//     console.log('ok')
		// })



	})
</script>