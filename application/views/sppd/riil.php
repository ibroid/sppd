<div class="content-wrapper container">
	<div class="page-heading">
		<h5>Pengeluaran RIIL SPPD</h5>
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
					<form action="<?= base_url('sppd/riil/' . $id) ?>" method="POST">
						<table class="table table-hover">
							<thead>
								<tr>
									<th width="400px">
										<input type="hidden" name="id" id="idpr">
										<input required type="text" name="keperluan" class="form-control" placeholder="Keperluan ..." id="keperluan">
									</th>
									<th width="200px">
										<input required type="number" name="harga" class="form-control" placeholder="Harga ..." id="harga">
									</th>
									<th width="100px">
										<input required type="number" name="jumlah" class="form-control" placeholder="Jumlah ..." id="jumlah">
									</th>
									<th>
										<input required type="date" name="tanggal" class="form-control" placeholder="Tanggal Dibeli ..." id="tanggal">
									</th>
									<th width="400px">
										<input required type="text" name="keterangan" class="form-control" placeholder="Keterangan ..." id="keterangan">
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="5" class="text-center">
										<a href="<?= base_url('sppd/daftar') ?>" class="btn btn-danger">Kembali</a>
										<button type="submit" name="submit" class="btn btn-success">Simpan</button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Keperluan</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Tanggal</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $n => $d) { ?>
								<tr>
									<td><?= ++$n ?></td>
									<td><?= $d->keperluan ?></td>
									<td><?= rupiah($d->harga)  ?></td>
									<td>x<?= $d->jumlah ?></td>
									<td><?= format_tanggal($d->tanggal)  ?></td>
									<td><?= $d->keterangan ?></td>
									<td>
										<a href="<?= base_url('sppd/hapus_riil/' . $d->id) ?>" class="btn btn-sm btn-danger">
											<i class="bi bi-trash"></i>
										</a>
										<button data-json='<?= $d ?>' class="btn btn-sm btn-warning btn-edit">
											<i class="bi bi-pencil"></i>
										</button>
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
	const btnEdit = document.querySelectorAll('.btn-edit');
	for (let i = 0; i < btnEdit.length; i++) {
		const element = btnEdit[i];
		element.addEventListener('click', () => {
			const data = JSON.parse(element.dataset.json)
			$('#idpr').val(data.id);
			$('#keperluan').val(data.keperluan);
			$('#harga').val(data.harga);
			$('#jumlah').val(data.jumlah);
			$('#keterangan').val(data.keterangan);
			$('#tanggal').val(data.tanggal);
		})

	}
</script>