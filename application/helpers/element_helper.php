<?php
// include_once APPPATH . 'models/SuratMasuk.php';
function checkFileSuratMasuk($list)
{
    if ($list->file) {
        return '<a target="_blank" href="' . base_url('/hasil/surat_masuk/' . $list->file) . '"><span class="badge icon bg-success">Download</span></a><a href="' . base_url('/surat/hapus_file_surat_masuk/' . $list->id) . '"  href="javascript:void(0)"><span class="badge bg-danger">Hapus</span></a>';
    }
    return '<a onclick="uploadFile(' . $list->id . ')"  href="javascript:void(0)"><span class="badge bg-danger icon">Upload</span></a>';
}
function checkFileSuratKeluar($list)
{
    if ($list->file) {
        return '<a target="_blank" href="' . base_url('/hasil/surat_keluar/' . $list->file) . '"><span class="badge icon bg-success">Download</span></a><a href="' . base_url('/surat/hapus_file_surat_keluar/' . $list->id) . '"  href="javascript:void(0)"><span class="badge bg-danger">Hapus</span></a>';
    }
    return '<a onclick="uploadFile(' . $list->id . ')"  href="javascript:void(0)"><span class="badge bg-danger icon">Upload</span></a>';
}

function checkDisposisi($id)
{
    $ci = get_instance();
    $cek = $ci->db->get_where('disposisi', ['surat_masuk_id' => $id])->result();
    if (!$cek) {
        return '<a href="javascript:void(0)" onclick="disposisi(' . $id . ')" class="btn btn-sm icon-left btn-success">Disposisi</a>';
    }
    return '<a href="javascript:void(0)" onclick="lihatDisposisi(' . $id . ')" class="btn btn-sm icon-left btn-primary">Lihat</a>';
}

function checkNomorSurat($list)
{
    if ($list->nomor_surat) {
        return '<a onclick="deleteSuratMasuk(' . $list->id . ')" class="btn btn-sm icon-left btn-danger">' . $list->nomor_surat . '<i class="bi bi-trash"></i></a>';
    }
    return '<a href="' . base_url('penomoran') . '" class="btn btn-sm icon-left btn-primary">Isi Nomor Surat</a>';
}

function inputNomorSurat($id, $value = null)
{
    $pengaturan = pengaturan();
    return '<input value="' . intval($pengaturan->nrt_surat_keluar + 1)   . '" name="nomor_surat" data-id="input-nomor-' . $id . '" id="input-nomor-' . $id . '" type="text" class="form-control form-realtime is-valid" id="valid-state" placeholder="Tulis Nomor Surat" required=""><div class="valid-feedback" id="feedback-nomor-' . $id . '" ><i class="bx bx-radio-circle"></i>Tersedia</div>';
}
function inputKodeSurat($id, $value)
{
    return '<input value="' . $value . '" type="text" class="form-control input-kode" id="input-kode-' . $id . '" name="kode_surat" placeholder="Tulis Kode Surat" required>';
}

function formatNomorSurat($nomor, $kode_surat)
{
    $pengaturan = pengaturan();

    $formatNomor = str_replace("{nomor}", $nomor, $pengaturan->nomor_surat);
    $formatNomor = str_replace("{tahun}", date('Y'), $formatNomor);
    $formatNomor = str_replace("{kode_surat}", $kode_surat, $formatNomor);
    $formatNomor = str_replace("{bulan_angka}", str_replace('0', '', date('m')), $formatNomor);

    return $formatNomor;
}
