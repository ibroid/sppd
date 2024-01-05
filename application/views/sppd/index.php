<div class="content-wrapper container">
	<div class="page-heading">
		<h2>Surat Perjalanan Dinas</h2>
	</div>
	<div class="page-body">
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
					<table id="daftar" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nomor Surat</th>
								<th>Tujuan</th>
								<th>Tugas</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($surattugas as $n => $v) { ?>
								<tr>
									<td><?= ++$n ?></td>
									<td>
										<p class="lh-1 fw-light"><?= ($v->nomor_surat) ? $v->nomor_surat : 'BELUM ADA NOMOR SURAT' ?></p>
									</td>
									<td>
										<p class="lh-1 fw-light"><?= $v->tujuan ?></p>
									</td>
									<td>
										<p class="lh-1 fw-light"><?= $v->tugas ?></p>
									</td>
									<td>
										<a href="<?= base_url('sppd/buat/' . $v->id) ?>" class="btn btn-danger btn-sm">Buat SPPD</a>
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
	$(document).ready(() => {
		const dataTable = new simpleDatatables.DataTable("#daftar");
	})
</script>