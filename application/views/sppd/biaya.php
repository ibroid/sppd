<div class="content-wrapper container">
	<div class="page-heading">
		<h5>Rincian Biaya SPPD</h5>
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
					<form action="<?= base_url('sppd/biaya/' . $this->uri->segment(3)) ?>" method="POST">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Untuk Keperluan</th>
									<th>Biaya</th>
									<th>Jumlah</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody id="rowForm">
								<?php if (isset($data)) { ?>
									<?php foreach ($data as $key => $value) { ?>
										<tr>
											<td>
												<input type="text" class="form-control" value="<?= $value->keperluan ?>" name="keperluan[]">
											</td>
											<td>
												<input type="number" class="form-control" value="<?= $value->biaya ?>" name="biaya[]">
											</td>
											<td>
												<input type="number" class="form-control" value="<?= $value->jumlah ?>" name="jumlah[]">
											</td>
											<td>
												<div class="input-group">
													<div class="input-group">
														<input type="text" name="keterangan[]" class="form-control" value="<?= $value->keterangan ?>" aria-label="Recipient's username" aria-describedby="button-addon2">
														<a href="<?= base_url('sppd/hapus_biaya/' . $value->id) ?>" class="btn btn-outline-danger" type="button"><i class="bi bi-trash"></i></a>
													</div>
												</div>
											</td>
										</tr>
									<?php } ?>
								<?php } ?>
								<tr>
									<td>
										<input type="text" required class="form-control" placeholder="Tuliskan Keperluan ... " name="keperluan[]">
									</td>
									<td>
										<input type="number" required class="form-control" placeholder="Tuliskan Biaya ... " name="biaya[]">
									</td>
									<td>
										<input type="number" required class="form-control" placeholder="Tuliskan Jumlah ... " name="jumlah[]">
									</td>
									<td>
										<input type="text" required class="form-control" placeholder="Tuliskan Keterangan ... " name="keterangan[]">
									</td>
								</tr>
							</tbody>
							<tbody>
								<tr>
									<td colspan="4" class="text-center">
										<a href="<?= base_url('keuangan') ?>" class="btn btn-danger">Kembali</a>
										<button type="button" id="tambahForm" class="btn btn-primary">Tambah Form</button>
										<button class="btn btn-success">Simpan Rincian Biaya</button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>

				</div>
			</div>
		</section>
	</div>
</div>

<script>
	$(document).ready(() => {
		let count = 1;
		const arcount = [];
		$('#tambahForm').on('click', () => {
			count = count + 1;
			arcount.push(`peg${count}`);
			console.log(arcount)
			$('#rowForm').append(`
            <tr id="peg${count}">
                <td>
                    <input type="text" class="form-control" placeholder="Tuliskan Keperluan ... " name="keperluan[]">
                </td>
                <td>
                    <input type="number" class="form-control" placeholder="Tuliskan Biaya ... " name="biaya[]">
                </td>
                <td>
                    <input type="number" class="form-control" placeholder="Tuliskan Jumlah ... " name="jumlah[]">
                </td>
                <td>
                    <input type="number" class="form-control" placeholder="Tuliskan Keterangan ... " name="keterangan[]">
                </td>
            </tr>
            `)

		})
	})
</script>