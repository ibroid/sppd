<?php
include_once APPPATH . 'models/SuratKeluar.php';
class Surat_keluar extends CI_Controller
{
  public $surat_keluar;

  public function __construct()
  {
    parent::__construct();
    if (isset($_POST["id"])) {
      $this->surat_keluar = SuratKeluar::find(request("id"));
    }
  }

  public function cek_sub_nomor()
  {
    try {
      if (request("tanggal_surat") == null or strlen(request("nomor_lanjutan")) <= 1) {
        throw new Exception("Tolong lengkapi tanggal surat dan isi nomor lanjutan surat", 1);
      }
      $check = SuratKeluar::whereDate("tanggal_surat", request("tanggal_surat"))->where("nomor_surat", request("nomor_lanjutan"))->first();
      // print_r($check);
      if ($check) {
        throw new Exception("Nomor surat sudah dipakai. Coba yang lain :)", 1);
      }
      echo "Nomor Bisa dipakai";
    } catch (\Throwable $th) {
      set_status_header(400);
      //throw $th;
      echo $th->getMessage();
    }
  }

  public function save_sub()
  {
    if (!must_post()) {
      show_404();
      exit;
    }

    try {
      SuratKeluar::create([
        'tanggal_surat' => request('tanggal_surat'),
        'tujuan' => request('tujuan'),
        'tanggal_dikirim' => request('tanggal_dikirim'),
        'perihal' => request('perihal'),
        'ringkasan_isi' => request('ringkasan_isi'),
        'catatan' => request('catatan'),
        'nomor_surat' => request('nomor_surat') . request("nomor_surat_lanjutan"),
      ]);
      $this->session->set_flashdata('notif', 'Surat keluar berhasil disimpan');
    } catch (\Throwable $th) {
      $this->session->set_flashdata('notif', $th->getMessage());
    }

    redirect($_SERVER["HTTP_REFERER"]);
  }
}
