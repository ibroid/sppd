<?php
$surat_relation = $this->db->query(
    "SELECT surat_keluar_id, relation_id, jenis_relation, nomor_surat, kode_surat FROM surat_keluar_relation JOIN surat_keluar ON surat_keluar_id = surat_keluar.id WHERE relation_id = $data->id"
)->row();

if (!$surat_relation) { ?>
    <form action="<?= base_url('/surat/add_from_sd') ?>" method="post">
        <input type="hidden" value="<?= $data->id ?>" name="id_sd">
        <input type="text" name="kode_surat" required class="form-control" list="daftar_kode" placeholder="Kode Surat">
        <datalist id="daftar_kode">
            <?php foreach ($kode as $kd) { ?>
                <option><?= $kd->kode_surat ?></option>
            <?php } ?>
        </datalist>
        <button class="btn btn-dark btn-sm">Tambah Nomor</button>
    </form>
<?php } else {
    echo $data->nomor_surat ?: 'Dalam Proses Penomoran';
} ?>