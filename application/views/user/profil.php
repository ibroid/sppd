<div class="content-wrapper container">
    <div class="page-heading">
        <h3>Profil </h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form User Pegawai</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <form class="form form-horizontal" method="POST" action="<?= base_url('kepegawaian/save_profile') ?>">
                                <div class="form-body">
                                    <div class="row">
                                        <?php if ($this->session->flashdata('notif_pegawai')) { ?>
                                            <div class="alert alert-light-info color-danger">
                                                <i class="bi bi-exclamation-circle"></i> <?= $this->session->flashdata('notif_pegawai') ?>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-2">
                                            <label>Nama</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="text" required name="nama" value="<?= $pegawai->nama ?>" class="form-control" placeholder="Nama Lengkap" id="first-name-icon">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>NIP</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="number" required name="nip" class="form-control" placeholder="NIP" value="<?= $pegawai->nip ?>" id="first-name-icon">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-card-list"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Jabatan</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <select name="jabatan_id" class="form-control">
                                                        <?php foreach ($jabatan as $jk => $jv) { ?>
                                                            <option <?= ($jv->id == $pegawai->jabatan_id) ? 'selected' : '' ?> value="<?= $jv->id ?>"><?= $jv->nama_jabatan ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person-badge-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Golongan</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <select name="golongan_id" class="form-control">
                                                        <?php foreach ($golongan as $gk => $gv) { ?>
                                                            <option <?= ($gv->id == $pegawai->golongan_id) ? 'selected' : '' ?> value="<?= $gv->id ?>"><?= $gv->nama_golongan ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person-lines-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success me-1 mb-1">
                                                <i class="bi bi-save"></i> Simpan Profil
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <form class="form form-horizontal" method="POST" action="<?= base_url('pengguna/change_credential') ?>">
                                <div class="form-body">
                                    <div class="row">
                                        <?php if ($this->session->flashdata('notif_pengguna')) { ?>
                                            <div class="alert alert-light-info color-danger">
                                                <i class="bi bi-exclamation-circle"></i> <?= $this->session->flashdata('notif_pengguna') ?>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-2">
                                            <label>Username</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="text" required name="username" value="<?= $user->username ?>" class="form-control" placeholder="Username" id="first-name-icon">
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
                                                    <input type="password" name="password" class="form-control" placeholder="Password" id="first-name-icon">
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
        </div>
    </div>
</div>