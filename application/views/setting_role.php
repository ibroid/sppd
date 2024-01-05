<div class="content-wrapper container-fluid">
    <div class="page-heading">
        <h3>Pengaturan Role Pengguna</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->flashdata('notif')) { ?>
                        <div class="alert alert-primary">
                            <i class="bi bi-info-circle-fill"></i> <?= $this->session->flashdata('notif')  ?>.<br>
                        </div>
                    <?php } ?>
                    <div class="text-end">
                        <button data-bs-toggle="modal" data-bs-target="#modalId" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Role</button>
                    </div>
                    <hr>
                    <table class="table table-responsive table-striped table-hover table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2" scope="col">No</th>
                                <th rowspan="2" scope="col">Role Name</th>
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
                            <?php foreach ($roles as $rk => $rv) { ?>
                                <tr>
                                    <td><?= ++$rk ?></td>
                                    <td><?= $rv->role_name ?></td>
                                    <?php foreach ($menu as $km => $vm) { ?>
                                        <td><?= check_access($vm->id, $rv->menu) ?></td>
                                    <?php } ?>
                                    <td><button onclick="editRole(this)" data-name="<?= $rv->role_name ?>" data-id="<?= $rv->id ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button></td>
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
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light" id="modalTitleId"><i class="bi bi-person-check-fill"></i> Tambah Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form form-horizontal" method="POST" action="<?= base_url('pengguna/add_role') ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Role Name</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" required name="role_name" class="form-control" placeholder="Role Name">
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Akses</label>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>Akses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($menu as $k => $m) { ?>
                                            <?php ++$k ?>
                                            <tr>
                                                <td><?= $m->menu_name ?></td>
                                                <td>
                                                    <div class="checkbox">
                                                        <input name="access_menu[]" type="checkbox" id="checkboxForm<?= $k ?>" value="<?= $m->id ?>" class="form-check-input">
                                                        <label for="checkboxForm<?= $k ?>">Akses</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-success"><i class="bi bi-clipboard-check"></i> Simpan</button>
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
                <h5 class="modal-title text-light" id="modalTitleId"><i class="bi bi-person-check-fill"></i> Ubah Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form form-horizontal" method="POST" action="<?= base_url('pengguna/edit_role_and_access') ?>">
                    <input type="hidden" name="id" id="input-hidden-role-id">
                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Role Name</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" required name="role_name" class="form-control" placeholder="Role Name" id="input-role-name">
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Akses</label>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>Akses</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-menu-akses">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-success"><i class="bi bi-clipboard-check"></i> Simpan</button>
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
    const editRole = async (el) => {

        Swal.fire({
            title: 'Mohon Tunggu',
            willOpen: () => Swal.showLoading(),
            backdrop: true,
            allowOutsideClick: false,
            showConfirmButton: false
        })

        const accessMenu = await fetch('<?= base_url('pengguna/role/') ?>' + el.dataset.id)
            .then(res => {
                if (!res.ok) {
                    throw new Error(res.statusText)
                }
                return res.json()
            })
            .then(res => res)
            .catch(err => Swal.fire('Terjadi Kesalahan', err.message, 'error'))

        const allMenu = JSON.parse('<?= json_encode($menu_name_only) ?>')

        let element = '';
        allMenu.forEach((row, i) => {
            element += `<tr>`
            element += `<td>`
            element += `${row.menu_name}`
            element += `</td>`
            element += `<td>`

            element += `<div class="checkbox">
                            <input name="access_menu[]" type="checkbox" id="checkbox${i}" value="${row.id}" class="form-check-input" ${checkAkses(row.id, accessMenu.menu)}>
                            <label for="checkbox${i}">Akses</label>
                        </div>`
            element += `</td>`
        });

        $('#input-hidden-role-id').val(el.dataset.id)
        $('#input-role-name').val(el.dataset.name)
        $('#tbody-menu-akses').html(element)
        globalModal.show()
        Swal.close()
    }

    const checkAkses = (idMenu, accessMenu) => {
        let result = [];
        accessMenu.forEach(row => {
            if (idMenu == row.id) {
                result.push(row.id)
            }
        });
        if (result.length < 1) {
            return ''
        }
        return 'checked="true"'

    }

    $(document).ready(() => {
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'))
        globalModal = modalEdit
    })
</script>