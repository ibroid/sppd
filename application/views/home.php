<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Dashboard</h3>
	</div>
	<div class="page-content">
		<?php if ($this->session->flashdata('notif')) { ?>
			<div class="alert alert-info">
				<strong>
					<?= $this->session->userdata('notif') ?>
				</strong>
			</div>
		<?php } ?>
		<?php if (pengaturan()->maintenance == 1) { ?>
			<div class="alert alert-danger">
				<strong>
					MAINTENANCE. TOLONG JANGAN DI PAKAI
				</strong>
			</div>
		<?php } ?>
		<section class="row">
			<div class="col-12 col-lg-9">
				<div class="row">
					<div class="col-6 col-lg-3 col-md-6">
						<div class="card">
							<div class="card-body px-2 py-4-5">
								<div class="row">
									<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
										<div class="stats-icon purple mb-2">
											<i class="iconly-boldArrow---Down"></i>
										</div>
									</div>
									<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
										<h6 class="text-muted font-semibold">
											Surat Masuk
										</h6>
										<h6 class="font-extrabold mb-0"><?= $surat_masuk->total ?></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-lg-3 col-md-6">
						<div class="card">
							<div class="card-body px-2 py-4-5">
								<div class="row">
									<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
										<div class="stats-icon blue mb-2">
											<i class="iconly-boldArrow---Up"></i>
										</div>
									</div>
									<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
										<h6 class="text-muted font-semibold">Surat Keluar</h6>
										<h6 class="font-extrabold mb-0"><?= $surat_keluar->total ?></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-lg-3 col-md-6">
						<div class="card">
							<div class="card-body px-2 py-4-5">
								<div class="row">
									<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
										<div class="stats-icon green mb-2">
											<i class="iconly-boldAdd-User"></i>
										</div>
									</div>
									<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
										<h6 class="text-muted font-semibold">Instrumen</h6>
										<h6 class="font-extrabold mb-0"><?= $instrumen->total ?></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-lg-3 col-md-6">
						<div class="card">
							<div class="card-body px-2 py-4-5">
								<div class="row">
									<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
										<div class="stats-icon red mb-2">
											<i class="iconly-boldBookmark"></i>
										</div>
									</div>
									<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
										<h6 class="text-muted font-semibold">Surat Tugas</h6>
										<h6 class="font-extrabold mb-0"><?= $spd->total ?></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-xl-4">
						<div class="card">
							<div class="card-header">
								<h4>Belum Ada Nomor Surat</h4>
							</div>
							<div class="card-body">
								<table class="table">
									<thead>
										<tr>
											<th>Tujuan</th>
											<th>Tanggal</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($surat_tanpa_nomor as $ks => $kv) { ?>
											<tr>
												<td><?= $kv->tujuan ?></td>
												<td> <?= format_tanggal($kv->tanggal_surat) ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
								<div class="px-4">
									<a href="<?= base_url('penomoran') ?>" class="btn btn-block btn-xl btn-light-primary font-bold mt-3">
										Lihat Detail
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-xl-8">
						<div class="card">
							<div class="card-header">
								<h4>Belum ada disposisi</h4>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover table-lg">
										<thead>
											<tr>
												<th>Dari</th>
												<th>Tanggal</th>
												<th>Perihal</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($blm_ada_disposisi as $ik => $iv) { ?>
												<tr>
													<td class="col-3">
														<?= $iv->asal ?>
													</td>
													<td class="col-auto">
														<p class="mb-0">
															<?= $iv->tanggal_surat ?>
														</p>
													</td>
													<td class="col-auto">
														<p class="mb-0">
															<?= $iv->perihal ?>
														</p>
													</td>
												</tr>
											<?php } ?>
											<?php if (empty($blm_ada_disposisi)) { ?>
												<tr>
													<td colspan="3"> Semua surat sudah di disposisi</td>
												</tr>
											<?php } ?>

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<h4>Statistik Surat</h4>
							</div>
							<div class="card-body">
								<div>
									<canvas id="myChart"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-3">
				<div class="card">
					<div class="card-body py-1 px-2">
						<div class="d-flex align-items-center">
							<div class="avatar avatar-xl">
								<img src="<?= base_url('logo/foto_ketua.png') ?>" alt="Foto Ketua" />
							</div>
							<div class="ms-3 name">
								<h5 class="font-bold"><?= pengaturan()->nama_ketua ?></h5>
								<h6 class="text-muted mb-0">Ketua Satuan Kerja</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h4>Daftar User</h4>
					</div>
					<div class="card-content pb-4">
						<?php foreach ($users as $uk => $uv) { ?>
							<div class="recent-message d-flex px-4 py-3">
								<div class="avatar avatar-lg">
									<img src="assets/images/faces/<?= rand(1, 8) ?>.jpg" />
								</div>
								<div class="name ms-4">
									<h5 class="mb-1"><?= $uv->pegawai->nama ?></h5>
									<h6 class="text-muted mb-0"><?= $uv->role->role_name ?></h6>
								</div>
							</div>
						<?php } ?>
						<!-- <div class="recent-message d-flex px-4 py-3">
							<div class="avatar avatar-lg">
								<img src="assets/images/faces/5.jpg" />
							</div>
							<div class="name ms-4">
								<h5 class="mb-1">Dean Winchester</h5>
								<h6 class="text-muted mb-0">@imdean</h6>
							</div>
						</div>
						<div class="recent-message d-flex px-4 py-3">
							<div class="avatar avatar-lg">
								<img src="assets/images/faces/1.jpg" />
							</div>
							<div class="name ms-4">
								<h5 class="mb-1">John Dodol</h5>
								<h6 class="text-muted mb-0">@dodoljohn</h6>
							</div>
						</div> -->
						<div class="px-4">
							<a href="<?= base_url('app/pengguna') ?>" class="btn btn-block btn-xl btn-light-primary font-bold mt-3">
								Tambah User
							</a>
						</div>
					</div>
				</div>
				<!-- <div class="card">
					<div class="card-header">
						<h4>Visitors Profile</h4>
					</div>
					<div class="card-body">
						<div id="chart-visitors-profile"></div>
					</div>
				</div> -->
			</div>
		</section>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	$(document).ready(() => {
		const ctx = document.getElementById('myChart');

		new Chart(ctx, {
			type: 'line',
			data: {
				labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
				datasets: [{
						label: 'Surat Masuk',
						data: [12, 19, 3, 5, 2, 3],
						borderWidth: 1
					},
					{
						label: 'Surat Keluar',
						data: [4, 10, 5, 4, 2, 5],
						borderWidth: 1
					}
				]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	})
</script>