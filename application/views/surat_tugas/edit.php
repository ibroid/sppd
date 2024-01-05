<div class="content-wrapper container">
    <div class="page-content">
        <form action="<?= base_url('penugasan/edit/' . $data->id) ?>" method="POST">
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Perihal Surat Tugas</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="menimbang">Surat tugas ini dikeluarkan atas Perihal</label>
                                    <input type="text" value="<?= $data->perihal ?>" name="perihal" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">1. Menimbang</h4>
                        <div class="text-end">
                            <button onclick="setSample('assets/sample_menimbang.png')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary text-end">Lihat Sample</button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="menimbang">Tulis Pertimbangan dalam Pembuatan Surat Tugas</label>
                                    <textarea required name="menimbang" class="form-control" cols="10" rows="3"><?= $data->menimbang ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">2. Dasar Hukum</h4>
                        <div class="text-end">
                            <button onclick="setSample('assets/sample_dasar_hukum.png')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary text-end">Lihat Sample</button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dasar_hukum">Tulis Dasar Hukum dalam Pembuatan Surat Tugas</label>
                                    <textarea required name="dasar_hukum" class="form-control" cols="10" rows="3"><?= $data->dasar_hukum ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">3. Tujuan</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tujuan">Tulis Tujuan yang akan di kunjungi</label>
                                    <input required type="text" value="<?= $data->tujuan ?>" name="tujuan" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">4. Deskripsi Tugas</h4>
                        <div class="text-end">
                            <button onclick="setSample('assets/sample_untuk.png')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary text-end">Lihat Sample</button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tugas">Tulis Deskripsi Tugas yang akan dilaksanakan</label>
                                    <textarea required name="tugas" class="form-control" cols="10" rows="3"><?= $data->tugas ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <center>

                    <a href="<?= base_url('penugasan/daftar') ?>" class="btn btn-lg btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-lg btn-success">Simpan</button>
                </center>
                <br>
            </section>
        </form>
    </div>
</div>