<select onchange="cek_nomor_surat_terakhir(this)" name="klasifikasi_surat" id="select-klasifikasi-surat-<?= $id ?>" data-surat-id="<?= $id ?>" class="form-control" required>
  <option value="" selected disabled>Pilih Klasifikasi Kode Surat</option>
  <?php foreach ($kode as $k) { ?>
    <option><?= $k->kode ?></option>
  <?php } ?>
</select>