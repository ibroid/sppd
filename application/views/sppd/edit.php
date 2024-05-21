<div class="content-wrapper container">
	<div class="page-heading">
		<h2>Surat Perjalanan Dinas</h2>
	</div>
	<div class="page-body">
		<section class="section">
			<div class="card">
				<div class="card-body">
					<form action="<?= base_url('sppd/edit') ?>" method="POST">
						<input type="hidden" name="id" value="<?= $sd->id ?>">
						<div class="row">
							<div class="form-group col-md-4">
								<label for="tanggal_berangkat">Tanggal Berangkat</label>
								<input type="date" name="tanggal_berangkat" class="form-control" value="<?= $sd->tanggal_berangkat ?>">
							</div>
							<div class="form-group col-md-6">
								<label for="tanggal_tiba">Tanggal Tiba di Tujuan</label>
								<input type="date" name="tanggal_tiba" class="form-control" value="<?= $sd->tanggal_tiba ?>">
							</div>
							<div class="form-group col-md-4">
								<label for="tanggal_pulang">Tanggal Pulang</label>
								<input type="date" name="tanggal_pulang" class="form-control" value="<?= $sd->tanggal_pulang ?>">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-6">
								<label for="tanggal_berangkat">Tempat Berangkat</label>
								<input value="<?= $sd->tempat_berangkat ?>" type="text" name="tempat_berangkat" class="form-control">
							</div>
							<div class="form-group col-md-6">
								<label for="tanggal_berangkat">Tempat Tujuan</label>
								<input type="text" value="<?= $sd->tempat_tujuan ?>" placeholder="Tulis Tempat Tujuan" name="tempat_tujuan" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label for="tanggal_berangkat">Maksud Keberangkatan</label>
								<textarea name="maksud_perjalanan" class="form-control" cols="5" rows="3"><?= $sd->maksud_perjalanan ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label for="transportasi">Angkutan/Transportasi yang Digunakan</label>
								<input type="text" placeholder="Tulis Angkutan/Transportasi Yang Dibutuhkan" name="transportasi" class="form-control" value="<?= $sd->transportasi ?>">
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<center>
									<a href="<?= base_url('sppd/daftar') ?>" class="btn btn-danger">Kembali</a>
									<button class="btn btn-success">Simpan</button>
								</center>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>