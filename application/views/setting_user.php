<div class="content-wrapper container-fluid">
	<div class="page-heading">
		<h3>Pengaturan Pengguna Aplikasi</h3>
	</div>
	<div class="page-content">
		<section class="section">
			<div class="card">
				<div class="card-body">
					<?php if ($this->session->flashdata('notif_pengguna')) { ?>
						<div class="alert alert-primary">
							<i class="bi bi-info-circle-fill"></i> <?= $this->session->flashdata('notif_pengguna')  ?>.<br>
						</div>
					<?php } ?>
					<div class="text-end">
						<button data-bs-toggle="modal" data-bs-target="#modalId" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Tambah User</button>
					</div>
					<hr>
					<table class="table table-responsive table-striped table-hover table-bordered">
						<thead class="text-center">
							<tr>
								<th rowspan="2" scope="col">No</th>
								<th rowspan="2" scope="col">User</th>
								<th rowspan="2" scope="col">Jabatan</th>
								<th rowspan="2" scope="col">Role</th>
								<th colspan="<?= count($menu) ?>" scope="col">Akses</th>
								<th rowspan="2" scope="col">Aksi</th>
							</tr>
							<tr>
								<?php foreach ($menu as $km => $vm) { ?>
									<th><?= $vm->menu_name ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($user as $uk => $uv) { ?>
								<tr class="text-center">
									<td><?= ++$uk ?></td>
									<td><?= $uv->username ?><br><?= $uv->pegawai->nama ?></td>
									<td> <?= $uv->pegawai->jabatan->nama_jabatan ?></td>
									<td><a onclick="changeRole(this)" data-id="<?= $uv->id ?>" href="javascript:void(0)" class="icon icon-left"><i class="bi bi-pencil-square"></i> <?= $uv->role->role_name ?></a></td>
									<?php foreach ($menu as $km => $vm) { ?>
										<td><?= check_access($vm->id, $uv->role->menu) ?></td>
									<?php } ?>
									<td><button onclick="editUser(this)" data-username="<?= $uv->username ?>" data-id="<?= $uv->id ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>

<div class="modal" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-white" id="modalTitleId"><i class="bi bi-person-plus-fill"></i> Tambah Pengguna Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="form form-horizontal" id="form-add-user" method="POST" action="<?= base_url('pengguna/save') ?>">
					<div class="form-body">
						<div class="row">
							<?php if ($this->session->flashdata('notif_user')) { ?>
								<div class="alert alert-light-info color-danger">
									<i class="bi bi-exclamation-circle"></i> <?= $this->session->flashdata('notif_user') ?>
								</div>
							<?php } ?>
							<div class="col-md-2">
								<label>Username</label>
							</div>
							<div class="col-md-10">
								<div class="form-group has-icon-left">
									<div class="position-relative">
										<input type="text" required name="username" required value="" class="form-control" placeholder="Nama Lengkap">
										<div class="form-control-icon">
											<i class="bi bi-person"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label>Password</label>
							</div>
							<div class="col-md-10">
								<div class="form-group has-icon-left">
									<div class="position-relative">
										<input type="password" name="password" required class="form-control" placeholder="Password">
										<div class="form-control-icon">
											<i class="bi bi-card-list"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label>Role</label>
							</div>
							<div class="col-md-10">
								<div class="form-group has-icon-left">
									<div class="position-relative">
										<select name="role_id" id="select-role" class="form-control" required>
											<option value="" selected disabled>Pilih Role</option>
											<?php foreach ($roles as $rk => $rv) { ?>
												<option value="<?= $rv->id ?>"><?= $rv->role_name ?></option>
											<?php } ?>
										</select>
										<div class="form-control-icon">
											<i class="bi bi-person-lines-fill"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label>Pegawai</label>
							</div>
							<div class="col-md-10">
								<div class="form-group has-icon-left">
									<div class="position-relative">
										<input type="hidden" name="pegawai_id" id="input-hidden-pegawai">
										<input type="text" class="form-control" id="input-pegawai" placeholder="Tulis Nama Pegawai" required>
										<div class="form-control-icon">
											<i class="bi bi-person"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
							</div>
							<div class="col-md-10">
								<div class="alert alert-info">
									<i class="bi bi-info-circle-fill"></i> Akses menu akan menyesuaikan dengan role user.<br>
									<div id="div-menu-list"></div>
								</div>
							</div>
							<div class="col-12 d-flex justify-content-end">
								<button type="submit" class="btn btn-success me-1 mb-1">
									<i class="bi bi-save"></i> Simpan Userdata
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal" id="modalEdit" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-warning">
				<h5 class="modal-title text-light" id="modalTitleId"><i class="bi bi-person-check-fill"></i> Ubah User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="form form-horizontal" method="POST" action="<?= base_url('pengguna/change_credential') ?>">
					<input type="hidden" name="id" id="input-hidden-id">
					<div class="form-body">
						<div class="row">

							<div class="col-md-2">
								<label>Username</label>
							</div>
							<div class="col-md-10">
								<div class="form-group has-icon-left">
									<div class="position-relative">
										<input type="text" required name="username" class="form-control" placeholder="Username" id="input-username">
										<div class="form-control-icon">
											<i class="bi bi-person"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label>Password</label>
							</div>
							<div class="col-md-10">
								<div class="form-group has-icon-left">
									<div class="position-relative">
										<input type="password" name="password" class="form-control" placeholder="Password">
										<div class="form-control-icon">
											<i class="bi bi-card-list"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
							</div>
							<div class="col-md-10">
								<div class="alert alert-warning">
									<i class="bi bi-exclamation-triangle"></i> Kosongkan password apabila tidak akan dirubah
								</div>
							</div>
							<div class="col-12 d-flex justify-content-end">
								<button type="submit" class="btn btn-success me-1 mb-1">
									<i class="bi bi-save"></i> Simpan Userdata
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script src="<?= base_url('assets/js/autocomplete.js') ?>"></script>

<script>
	var globalModal = null;
	editUser = (el) => {
		if (globalModal == null) {
			return Swal.fire('Data Belum Siap');
		}
		$('#input-hidden-id').val(el.dataset.id)
		$('#input-username').val(el.dataset.username)
		globalModal.show()
	}

	const changeRole = async (el) => {

		const roles = JSON.parse('<?= json_encode($roles) ?>')
		const res_roles = new Map()
		roles.forEach(role => {
			res_roles.set(role.id, role.role_name)
		});
		Swal.fire({
			title: 'Pilih Role',
			input: 'select',
			inputOptions: res_roles,
			inputPlaceholder: 'Pilih Satu',
			showCancelButton: true,
			inputValidator: (value) => {
				return new Promise((resolve) => {
					resolve()
				})
			},
			showLoaderOnConfirm: true,
			preConfirm: (value) => {
				const body = new FormData()
				body.append('id', el.dataset.id)
				body.append('role_id', value)
				return fetch('<?= base_url('pengguna/update_role') ?>', {
						method: 'POST',
						body: body
					})
					.then((res) => {
						if (!res.ok) {
							throw new Error(res.statusText)
						}
						return res.json()
					})
					.catch(err => {
						Swal.showValidationMessage(`Request failed: error`)
					})
			}
		}).then((result) => {
			if (result.isConfirmed) {
				Swal.fire(result.value)
					.then(() => location.reload())
			}
		})

	}
	$(document).ready(() => {
		const ac = new Autocomplete(document.getElementById('input-pegawai'), {
			data: JSON.parse('<?= $pegawai ?>'),
			maximumItems: 5,
			onSelectItem: ({
				label,
				value
			}) => {
				console.log(value, label)
				document.getElementById('input-hidden-pegawai').value = value
			}
		});

		$('#select-role').change(async () => {

			Swal.fire({
				title: 'Mohon Tunggu',
				willOpen: () => Swal.showLoading(),
				backdrop: true,
				allowOutsideClick: false,
				showConfirmButton: false
			})

			await fetch('<?= base_url('pengguna/role/') ?>' + $('#select-role').val())
				.then((res) => {
					if (!res.ok) {
						throw new Error(res.statusText)
					}
					return res.json()
				})
				.then(res => {
					let el = '';
					res.menu.forEach(row => {
						el += `<span class="badge bg-danger m-1">${row.menu_name}</span>`;
					});
					$('#div-menu-list').html(el)
					Swal.close()
				})
				.catch(err => {
					Swal.fire('Error', err.message, 'error')
				})
		})


		const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'))
		// modalEdit.show()
		globalModal = modalEdit

		$('#form-add-user').on('submit', (e) => {
			e.preventDefault()
			if ($('#input-hidden-pegawai').val() == '') {
				Swal.fire('Pegawai Harus Ditentukan')
			} else {
				document.getElementById('form-add-user').submit()
			}
		})

	})
</script>