<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manajemen dan Sistem Suart</title>
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/favicon') ?>/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon') ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon') ?>/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url('assets/favicon') ?>/site.webmanifest">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css"> -->
	<link rel="stylesheet" href="<?= base_url() ?>bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/iconly/bold.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css">


	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

	<link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">

	<script src="https://unpkg.com/jquery@3.7.1/dist/jquery.min.js"></script>
	<script src="<?= base_url('assets/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>
	<script src="https://unpkg.com/flatpickr"></script>
</head>

<body>
	<div id="app">
		<div id="main" class="layout-horizontal">
			<header class="mb-4">
				<div class="header-top">
					<div class="container">
						<div class="logo">
							<a href="index.html"><img src="<?= base_url($_ENV["TITLE_IMAGE"]) ?>" height="200px" alt="Logo" srcset=""></a>
						</div>
						<div class="header-top-right">
							<!--  -->
							<div class="dropdown" style="margin-bottom: -10px">
								<a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
									<div class="avatar avatar-md2">
										<img src="<?= base_url('assets/images/faces/1.jpg') ?>" alt="Avatar" />
									</div>
									<div class="text" style="margin-left: 10px;margin-top:5px">
										<h6 class="user-dropdown-name"><?= auth()->pegawai['nama'] ?></h6>
									</div>
								</a>
								<ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
									<li><a class="dropdown-item" href="<?= base_url('pengguna') ?>">Profil</a></li>
									<li>
										<hr class="dropdown-divider" />
									</li>
									<li>
										<a class="dropdown-item" href="<?= base_url('auth/end') ?>">Logout</a>
									</li>
								</ul>
							</div>
							<!--  -->
							<a href="#" class="burger-btn d-block d-xl-none">
								<i class="bi bi-justify fs-3"></i>
							</a>
						</div>
					</div>
				</div>
				<nav class="main-navbar">
					<div class="container-fluid container">
						<ul>
							<?php foreach (accessible_menu() as $km => $vm) { ?>
								<li class="menu-item <?= empty(json_decode($vm->sub, true))  ? '' : 'has-sub' ?>">
									<a href="<?= ($vm->menu_link == '#') ? '#' : base_url($vm->menu_link) ?>" class='menu-link '>
										<?= $vm->menu_icon ?>
										<span><?= $vm->menu_name ?></span>
									</a>
									<?php if (!empty(json_decode($vm->sub, true))) { ?>
										<div class="submenu">
											<div class="submenu-group-wrapper">
												<ul class="submenu-group">
													<?php foreach (json_decode($vm->sub, true) as $sk => $sv) { ?>
														<li class="submenu-item">
															<a href="<?= base_url($sv['sub_link'])  ?>" class='submenu-link'><?= $sv['sub_name'] ?></a>
														</li>
													<?php } ?>
												</ul>
											</div>
										</div>
									<?php } ?>
								</li>
							<?php } ?>
						</ul>
					</div>
				</nav>
			</header>
			<?= $contents ?>
			<footer>
				<div class="container">
					<div class="footer clearfix mb-0 text-muted">
						<div class="float-start">
							<p>2021 &copy; <?= pengaturan()->nama_satker; ?></p>
						</div>
						<div class="float-end">
							<p>Created with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a target="_blank" href="https://mmaliki.my.id">Maliki</a></p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/js/pages/horizontal-layout.js"></script>
	<script src="<?= base_url() ?>assets/vendors/simple-datatables/simple-datatables.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
	<script src="<?= base_url('assets/js/autocomplete.js') ?>"></script>
	<script>
		$(".datepicker").flatpickr({});
	</script>

</body>

</html>