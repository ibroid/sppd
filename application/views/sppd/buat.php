<div class="content-wrapper container">
    <div class="page-heading">
        <h2>Surat Perjalanan Dinas</h2>
    </div>
    <div class="page-body">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('sppd/buat') ?>" method="POST">
                        <input type="hidden" name="surat_tugas_id" value="<?= $surattugas->id ?>">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="tanggal_berangkat">Tanggal Berangkat</label>
                                <input required type="date" name="tanggal_berangkat" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tanggal_tiba">Tanggal Tiba Di tempat Tujuan</label>
                                <input required type="date" name="tanggal_tiba" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tanggal_pulang">Tanggal Pulang</label>
                                <input required type="date" name="tanggal_pulang" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tanggal_berangkat">Tempat Berangkat</label>
                                <input value="Pengadilan Tinggi Agama DKI Jakarta" type="text" name="tempat_berangkat" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_berangkat">Tempat Tujuan</label>
                                <input type="text" value="<?= $surattugas->tujuan ?>" placeholder="Tulis Tempat Tujuan" name="tempat_tujuan" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="tanggal_berangkat">Maksud Keberangkatan</label>
                                <textarea name="maksud_perjalanan" class="form-control" cols="5" rows="3"><?= $surattugas->tugas ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="transportasi">Angkutan/Transportasi yang Digunakan</label>
                                <input type="text" placeholder="Tulis Angkutan/Transportasi Yang Dibutuhkan" name="transportasi" class="form-control">
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