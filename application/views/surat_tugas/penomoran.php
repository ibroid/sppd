<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Penomoran Surat Tugas</h3>
	</div>
	<div class="page-content">
		<section class="section">
			<?php if ($this->session->flashdata('notif')) { ?>
				<div class="alert alert-info">
					<strong><?= $this->session->flashdata('notif') ?></strong>
				</div>
			<?php } ?>
			<div class="card">
				<div class="card-body">
					<form action="<?= base_url('penomoran/format') ?>" method="POST">
						<!-- <div class="row">
							<div class="form-group col-md-3">
								<label for="">Tetapkan Format Penomoran Surat</label>
								<input type="text" class="form-control" value="<?= pengaturan()->nomor_surat ?>" name="nomor_surat">
							</div>
							<div class="col-md-2">
								<button class="btn btn-success mt-4">Update</button>
							</div>
						</div> -->
					</form>
					<table id="daftar" class="table table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Tujuan</th>
								<th>Dibuat</th>
								<th>Tanggal & <br> Nomor Surat</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $n => $d) { ?>
								<tr>
									<td><?= ++$n ?></td>
									<td width="500">
										<?= $d->tujuan ?><br>
										<details>
											<summary>Tugas</summary>
											<p><?= $d->tugas ?></p>
										</details>
									</td>
									<td>
										<?= $d->created_at->locale('id')->isoFormat('LLLL Y') ?>
										<br>
										<?= $d->created_at->locale('id')->diffForHumans() ?>
									</td>
									<td>
										<form autocomplete="off" action="<?= base_url('penomoran/update/' . $d->id) ?>" id="formPenomoran<?= $n ?>" method="POST">
											<input type="date" required class="form-control form-control-date" name="tanggal_surat" value="<?= $d->tanggal_surat ?>">
											<input type="text" required name="nomor_surat" class="form-control <?= ($d->nomor_surat) ? '' : 'is-invalid' ?>" placeholder="Masukan Nomor Surat" value="<?= $d->nomor_surat ?>" id="validationServer03" aria-describedby="validationServer03Feedback" required>
											<div id="validationServer03Feedback" class="invalid-feedback">
												Belum Ada Nomor Surat
											</div>
											<button class="btn btn-success btn-sm">Update</button>
										</form>
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