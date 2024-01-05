<div class="content-wrapper container-fluid">
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
					<h4>Daftar Surat Tugas</h4>
					<table id="tableSuratTugas" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Perihal</th>
								<th>Tujuan</th>
								<th>Tugas</th>
								<th>Nomor</th>
								<th>Pegawai</th>
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
				<h5 class="modal-title" id="staticBackdropLabel">Edit Pegawai</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('penugasan/edit_pegawai') ?>" method="post">
					<input type="hidden" id="hiddenFormParams" name="surat_tugas_id">
					<div id="fieldPegawai">

					</div>
					<div class="row">
						<div class="col-md mt-3">
							<button id="tambahFieldButton" type="button" class="btn btn-primary btn-block">Tambah Form </button>
						</div>
						<div class="col-md mt-3">
							<button id="hapusFieldButton" type="button" class="btn btn-danger btn-block">Hapus Form </button>
						</div>
						<div class="col-md mt-3">
							<button type="submit" class="btn btn-success btn-block">Simpan Pegawai</button>
						</div>
						<div class="col-md mt-3">
							<button type="button" class="btn btn-dark btn-block" data-bs-dismiss="modal">Tutup Layar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- MODAL PRINT -->
<div class="modal fade" id="modalConfigPrint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Konfigurasi Print</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('penugasan/cetak') ?>" method="POST">
					<input type="hidden" name="id" id="id_surat_tugas">
					<div class="row">
						<div class="form-group col-md-4">
							<label for="template">Pilih Template Surat Tugas</label>
							<select required class="form-control" id="template" name="template">
								<option selected value="template_surat_tugas_full.docx">Surat Tugas (Full)</option>
								<option value="template_surat_tugas_transport.docx">Surat Tugas (Transport Saja)</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="penandatangan">Pilih Penanda Tangan</label>
							<select required class="form-control" name="penandatangan">
								<option value="Ketua" selected>Ketua (Default)</option>
								<option>Wakil</option>
								<option>Panitera</option>
								<option>Sekretaris</option>
								<?php foreach ($plh as $p) { ?>
									<option value="<?= $p->id ?>">(PLH) <?= $p->nama_pejabat ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="referensi">Pilih Referensi Biaya</label>
							<select required class="form-control" name="referensi" id="referensi">
								<option value="1" selected>Dipa 01 (Default)</option>
								<option value="4">Dipa 04</option>
							</select>
						</div>
					</div>
					<button class="btn btn-lg btn-success">Cetak</button>
				</form>
			</div>
		</div>
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
<script>
	const fetchBeforePrint = (id) => {
		$('#id_surat_tugas').val(id)
	}

	$(document).ready(() => {
		$('#tableSuratTugas').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
			},
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": '<?= base_url('penugasan/datatable') ?>',
				"type": "POST"
			},
			"drawCallback": () => {
				$('#formTemplate').on('submit', async (e) => {
					Swal.showLoading();
					e.preventDefault()
					const body = new FormData(document.getElementById('formTemplate'))
					const postReq = await fetch("<?= base_url('cetak/surat_tugas_template') ?>", {
						method: 'POST',
						body: body
					}).then(res => res.json())
					console.log(postReq);
					Swal.fire("Template berhasil diubah");
				})

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

				$('#formBiayaReferens').on('submit', async (e) => {
					Swal.showLoading();
					e.preventDefault()
					const body = new FormData()
					body.append('referensi', $('#referensi').val())
					const postReq = await fetch("<?= base_url('penugasan/referensi_biaya') ?>", {
						method: 'POST',
						body: body
					}).then(res => res.json())
					console.log(postReq);

					Swal.fire("Referensi Biaya berhasil Dipilih");
				})


				let count = 1;
				const arcount = [];
				$('#tambahFieldButton').on('click', () => {
					count = count + 1;
					arcount.push(`peg${count}`);
					console.log(arcount)
					$('#fieldPegawai').append(`
            <div id="peg${count}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama[]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Jabatan</label>
                        <input type="text" list="jabatan" class="form-control" name="jabatan[]">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nama">Pangkat</label>
                        <input type="text" list="pangkat" class="form-control" name="pangkat[]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nama">Golongan</label>
                        <input type="text" list="golongan" class="form-control" name="golongan[]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nama">NIP</label>
                        <input type="text" class="form-control" name="nip[]">
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
				$('#btnLihatPegawai').on('click', (e) => {
					// console.log(e.target.dataset.id)
					const dataPegawai = JSON.parse(e.target.dataset.json)
					$('#hiddenFormParams').val(e.target.dataset.id)
					let elString = '';
					dataPegawai.forEach(row => {
						elString += `
			        <div class="row">
			            <div class="col-md-6">
			                <div class="form-group">
			                    <label for="nama">Nama</label>
			                    <input type="hidden" value="${row.id}" name="id[]">
			                    <input type="text" class="form-control" value="${row.nama}" name="nama[]">
			                </div>
			            </div>
			            <div class="col-md-6">
			                <div class="form-group">
			                    <label for="nama">Jabatan</label>
			                    <input type="text" list="jabatan" value="${row.jabatan}" class="form-control" name="jabatan[]">
			                </div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-md-4">
			                <div class="form-group">
			                    <label for="nama">Pangkat</label>
			                    <input type="text" list="pangkat" value="${row.pangkat}" class="form-control" name="pangkat[]">
			                </div>
			            </div>
			            <div class="col-md-4">
			                <div class="form-group">
			                    <label for="nama">Golongan</label>
			                    <input type="text" list="golongan" value="${row.golongan}" class="form-control" name="golongan[]">
			                </div>
			            </div>
			            <div class="col-md-4">
			                <div class="form-group">
			                    <label for="nama">NIP</label>
			                    <input type="text" class="form-control" value="${row.nip}" name="nip[]">
			                </div>
			            </div>
			        </div><strong><hr></strong>`
					});
					$('#fieldPegawai').html(elString)
				})

			}
		});

	})
</script>