<?php $pengaturan = pengaturan() ?>

<input value="" disabled name="nomor_surat" data-id="input-nomor-<?= $id ?>" id="input-nomor-<?= $id ?>" type="text" class="form-control form-realtime is-invalid" placeholder="Tulis Nomor Surat" required="">
<div class="valid-feedback" id="feedback-nomor-<?= $id ?>"><i class="bx bx-radio-circle"></i>Tersedia</div>
<div class="invalid-feedback" id="feedback-nomor-<?= $id ?>"><i class="bx bx-radio-circle"></i>Silahkan Isi Kode dan Klasifikasi Surat Terlebih dahulu</div>