<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Pembuatan Surat Perjalanan Tugas</h3>
	</div>
	<div class="page-content">
		<form action="<?= base_url('penugasan/tambah') ?>" method="POST">
			<section class="section">
				<?php if (pengaturan()->maintenance == 1) { ?>
					<div class="alert alert-danger">
						<strong>
							MAINTENANCE. TOLONG JANGAN DI PAKAI
						</strong>
					</div>
				<?php } ?>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Perihal Surat Tugas</h4>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="menimbang">Surat tugas ini dikeluarkan atas Perihal</label>
									<input type="text" name="perihal" class="form-control" required>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">1. Menimbang</h4>
						<div class="text-end">
							<button onclick="setSample('assets/sample_menimbang.png')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary text-end">Lihat Sample</button>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="menimbang">Tulis Pertimbangan dalam Pembuatan Surat Tugas</label>
									<textarea required name="menimbang" class="form-control" cols="10" rows="3"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">2. Dasar Hukum</h4>
						<div class="text-end">
							<button onclick="setSample('assets/sample_dasar_hukum.png')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary text-end">Lihat Sample</button>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="dasar_hukum">Tulis Dasar Hukum dalam Pembuatan Surat Tugas</label>
									<textarea required name="dasar_hukum" class="form-control" cols="10" rows="3"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">3. Penugasan</h4>
						<div class="alert alert-info">
							<strong>Perhatian</strong>
							<ul>
								<li>Kosongkan Semua Form Pegawai Apabila Akan Mengambil Dari Referensi</li>
							</ul>
						</div>
						<h4 class="card-title">Masukan Nama-nama pegawai yang akan ditugaskan</h4>
						<button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary">Referensi Pegawai</button>
						<button onclick="setSample('assets/sample_pegawai.png')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning text-end">Lihat Sample</button>
						<div id="fieldPegawai">
							<center>
								<h1 class="card-title">Pegawai 1</h1>
							</center>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama">Nama</label>
										<input type="text" class="form-control input-nama" name="nama[]">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama">Jabatan</label>
										<input type="text" list="jabatan" class="form-control input-jabatan" name="jabatan[]">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="nama">Pangkat</label>
										<input type="text" list="pangkat" class="form-control input-pangkat" name="pangkat[]">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="nama">Golongan</label>
										<input type="text" list="golongan" class="form-control input-golongan" name="golongan[]">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="nama">NIP</label>
										<input type="text" class="form-control input-nip" name="nip[]">
									</div>
								</div>
							</div>
							<hr>
						</div>
						<div class="row">
							<div class="col-md mt-4">
								<button id="tambahFieldButton" type="button" class="btn btn-primary btn-block">Tambah Form</button>
							</div>
							<div class="col-md mt-4">
								<button id="hapusFieldButton" type="button" class="btn btn-danger btn-block">Hapus Form</button>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">4. Tujuan</h4>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="tujuan">Tulis Tujuan yang akan di kunjungi</label>
									<input required type="text" name="tujuan" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">5. Deskripsi Tugas</h4>
						<div class="text-end">
							<button onclick="setSample('assets/sample_untuk.png')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary text-end">Lihat Sample</button>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="tugas">Tulis Deskripsi Tugas yang akan dilaksanakan</label>
									<textarea required name="tugas" class="form-control" cols="10" rows="3"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<center>

					<a href="<?= base_url('penugasan/daftar') ?>" class="btn btn-lg btn-danger">Kembali</a>
					<button type="submit" class="btn btn-lg btn-success">Simpan</button>
				</center>
				<br>
			</section>
		</form>
	</div>
</div>
<datalist id="pangkat">
	<?php foreach ($golongan as $g) { ?>
		<option><?= $g->nama_golongan ?></option>
	<?php } ?>
</datalist>
<datalist id="golongan">
	<?php foreach ($golongan as $gs) { ?>
		<option><?= $gs->kode_golongan ?></option>
	<?php } ?>
</datalist>
<datalist id="jabatan">
	<?php foreach ($jabatan as $j) { ?>
		<option><?= $j->nama_jabatan ?></option>
	<?php } ?>
</datalist>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Referensi Pegawai</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table id="daftar" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Jabatan</th>
							<th>Pangkat</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>

						<?php foreach ($pegawai as $n => $p) { ?>
							<tr>
								<td><?= $p->nama ?></td>
								<td><?= $p->jabatan->nama_jabatan ?></td>
								<td><?= $p->golongan->nama_golongan ?></td>
								<td><button data-json='<?= $p ?>' type="button" data-bs-dismiss="modal" class="btn btn-pilih btn-warning btn-sm">Pilih</button></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body bg-dark text-center">
				<img src="" alt="sample.png" id="foto_sample">
			</div>
		</div>
	</div>
</div>
<script>
	const setSample = (par) => {
		$('#foto_sample').attr('src', "<?= base_url() ?>/" + par)
	}
	$(document).ready(() => {
		let count = 1;
		const arcount = [];

		const dataTable = new simpleDatatables.DataTable("#daftar");
		const btnPilih = document.querySelectorAll('.btn-pilih');

		function appendValue(par, data) {
			const elements = document.querySelectorAll(par);

			console.log(elements)

			for (let i = 0; i < elements.length; i++) {
				const element = elements[i];

				if (element.value == '') {
					element.value = data
				}
			}
		}



		for (let i = 0; i < btnPilih.length; i++) {
			const element = btnPilih[i];
			element.addEventListener('click', () => {
				const data = JSON.parse(element.dataset.json);
				console.log(data)

				appendValue('.input-nama', data.nama)
				appendValue('.input-jabatan', data.jabatan.nama_jabatan)
				appendValue('.input-pangkat', data.golongan.nama_golongan)
				appendValue('.input-golongan', data.golongan.kode_golongan)
				appendValue('.input-nip', data.nip)


			})

		}

		dataTable.on('datatable.search', () => {
			const btnPilih = document.querySelectorAll('.btn-pilih');
			for (let i = 0; i < btnPilih.length; i++) {
				const element = btnPilih[i];
				element.addEventListener('click', () => {
					const data = JSON.parse(element.dataset.json);
					console.log(data)

					appendValue('.input-nama', data.nama)
					appendValue('.input-jabatan', data.jabatan.nama_jabatan)
					appendValue('.input-pangkat', data.golongan.nama_golongan)
					appendValue('.input-golongan', data.golongan.kode_golongan)
					appendValue('.input-nip', data.nip)

				})
			}
		})

		dataTable.on('datatable.page', () => {
			console.log('ok')
			const btnPilih = document.querySelectorAll('.btn-pilih');
			for (let i = 0; i < btnPilih.length; i++) {
				const element = btnPilih[i];
				element.addEventListener('click', () => {
					const data = JSON.parse(element.dataset.json);
					console.log(data)

					appendValue('.input-nama', data.nama)
					appendValue('.input-jabatan', data.jabatan.nama_jabatan)
					appendValue('.input-pangkat', data.golongan.nama_golongan)
					appendValue('.input-golongan', data.golongan.kode_golongan)
					appendValue('.input-nip', data.nip)

				})
			}
		})


		$('#tambahFieldButton').on('click', () => {
			count = count + 1;
			arcount.push(`peg${count}`);
			console.log(arcount)
			$('#fieldPegawai').append(`
            <div id="peg${count}">
            <center>
                <h1 class="card-title">Pegawai ${count}</h1>
            </center>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control input-nama" name="nama[]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Jabatan</label>
                        <input type="text" list="jabatan" class="form-control input-jabatan" name="jabatan[]">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nama">Pangkat</label>
                        <input type="text" list="pangkat" class="form-control input-pangkat" name="pangkat[]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nama">Golongan</label>
                        <input type="text" list="golongan" class="form-control input-golongan" name="golongan[]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nama">NIP</label>
                        <input type="text" class="form-control input-nip" name="nip[]">
                    </div>
                </div>
            </div>
            <hr>
            </div>
            `)
		})
		$('#hapusFieldButton').on('click', () => {
			const lastfield = arcount[arcount.length - 1]
			$('#' + lastfield).remove();
			count = count - 1;
			arcount.pop()
		})
	})
</script>