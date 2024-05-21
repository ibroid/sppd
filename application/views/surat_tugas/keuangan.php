<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Keuangan Surat Dinas</h3>
	</div>
	<div class="page-content">
		<section class="section">
			<div class="card">
				<div class="card-body">
					<table id="daftar" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="300px">Nomor Surat</th>
								<th>Pegawai</th>
								<th>Biaya</th>
								<th>Pengeluaran <br> Riil</th>
								<th>aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $n => $d) { ?>
								<tr>
									<td><?= $d->surat_tugas->nomor_surat ?><br>Tujuan : <?= $d->surat_tugas->tujuan ?></td>
									<td>
										Total <?= $d->surat_tugas->pegawai->count('*')  ?> Pegawai
										<br>
										<details>
											<summary>Detail</summary>
											<ul>
												<?php foreach ($d->surat_tugas->pegawai as $p) { ?>
													<li><?= $p->nama ?></li>
												<?php } ?>
											</ul>
										</details>
									</td>
									<td>
										<?php if (isset($d->biaya)) { ?>

											<button id="btn-detail-biaya" data-id="<?= $d->id ?>" class="btn btn-success btn-sm">
												Detail
											</button>
										<?php } else {
											echo "<span class='badge bg-danger'>Belum Ada Pengeluaran</span>";
										} ?>
									</td>
									<td>
										<?php if (isset($d->riil)) { ?>

											<button id="btn-detail-pengeluaran" data-id="<?= $d->id ?>" class="btn btn-success btn-sm">Detail</button>
										<?php } else {
											echo  "<span class='badge bg-danger'>Belum Ada Pengeluaran</span>";
										} ?>
									</td>
									<td>
										<div class="dropdown">
											<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
												Pilihan
											</button>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
												<li><a class="dropdown-item" href="<?= base_url('sppd/biaya/' . $d->id) ?>">Rincian Biaya</a></li>
												<li><a class="dropdown-item" href="<?= base_url('sppd/riil/' . $d->id) ?>">Pengeluaran Riil</a></li>
											</ul>
										</div>
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


<div class="modal fade" id="modalBiaya" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitleId">Rincian Biaya</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="detail-content">
				Body
			</div>

		</div>
	</div>
</div>


<script>
	$(document).ready(() => {
		var modalBiaya = new bootstrap.Modal(document.getElementById('modalBiaya'))

		var spinnerElement = `<div class="spinner-border  spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>`;
		$('#daftar').DataTable()

		$('#btn-detail-biaya').click(() => {
			fetchDetail($('#btn-detail-biaya'), 'keuangan/biaya_spd')
		})

		$('#btn-detail-pengeluaran').click(() => {
			fetchDetail($('#btn-detail-pengeluaran'), 'keuangan/pengeluaran_riil')
		})

		const fetchDetail = (those, url) => {
			those.html(spinnerElement).attr('disabled', true)

			const body = new FormData()
			body.append('need', 'TABLE_ELEMENT')
			body.append('id', those.data('id'))

			fetch('<?= base_url() ?>' + url, {
					method: 'POST',
					body: body
				})
				.then(res => {
					if (!res.ok) {
						throw new Error(res.statusText)
					}
					return res.text()
				})
				.then(res => {
					$('#detail-content').html(res)
					modalBiaya.show()
				})
				.catch(err => {
					console.log(err)
					Swal.fire('Terjadi Kesalahan', err.message, 'error')
				})
				.finally(() => {
					those.html('Detail').attr('disabled', false)
				})
		}
	})
</script>