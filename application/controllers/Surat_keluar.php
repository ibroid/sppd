<?php

use Illuminate\Support\Collection;

include_once APPPATH . 'models/SuratKeluar.php';
class Surat_keluar extends CI_Controller
{
  public $surat_keluar;

  public function __construct()
  {
    parent::__construct();
    if (auth()->check() == null) {
      redirect('auth');
    }

    if (isset($_POST["id"])) {
      $this->surat_keluar = SuratKeluar::find(request("id"));
    }

    $this->load->database();
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

  public function baru()
  {
    template('template', 'surat_keluar/surat_keluar_baru');
  }

  public function datatable_baru()
  {
    if (!must_post()) {
      show_404();
      exit;
    }

    $this->load->helper('element');
    $this->load->model('SuratKeluarDatatable');
    $lists = $this->SuratKeluarDatatable->get_datatables();

    $this->render_datatable($lists);
  }

  public function datatable_klasifikasi($kode)
  {
    if (!must_post()) {
      show_404();
      exit;
    }

    $this->load->helper('element');
    $this->load->model('SuratKeluarDatatable');

    $this->SuratKeluarDatatable->klasifikasi = $kode;
    $lists = $this->SuratKeluarDatatable->get_datatables();

    $this->render_datatable($lists);
  }

  private function render_datatable($lists)
  {
    $data = array();
    $no = $this->input->post('start');
    foreach ($lists as $list) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $list->tujuan . '<br>Kode: ' . $list->kode_surat;
      $row[] = checkNomorSurat($list) .  '<br>' . $this->checkSubNomor($list->nomor_surat);
      $row[] = format_tanggal($list->tanggal_surat);
      $row[] = $list->perihal . '<details>' . $list->ringkasan_isi . '</details>';
      $row[] = format_tanggal($list->tanggal_dikirim) . '<br>Catatan : ' . $list->catatan;
      $row[] = checkFileSuratKeluar($list);
      $row[] = '<button onclick="editData(this)" data-json=\'' . json_encode($list, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '\' class="btn btn-warning  btn-sm">Edit</button><button onclick="deleteData(' . $list->id . ')" class="btn btn-danger btn-sm">Hapus</button>';
      $data[] = $row;
    }
    $output = array(
      "draw" => $this->input->post('draw'),
      "recordsTotal" => $this->SuratKeluarDatatable->count_all(),
      "recordsFiltered" => $this->SuratKeluarDatatable->count_filtered(),
      "data" => $data,
    );
    header('Content-Type: application/json');
    $this->output->set_output(json_encode($output));
  }

  private function checkSubNomor($nomor_surat)
  {
    if ($this->SuratKeluarDatatable->klasifikasi) {
      return '<a target="_blank" href="' . base_url('/surat/sub_nomor/' . $nomor_surat) . '" class="btn btn-sm btn-dark">Sub Nomor</a>';
    }
  }

  public function klasifikasi($kode = null)
  {
    if (isset($_POST['awal']) && isset($_POST['akhir'])) {
      $this->session->set_userdata('awal_periode', request('awal'));
      $this->session->set_userdata('akhir_periode', request('akhir'));
    }

    if (isset($_GET['reset'])) {
      $this->session->unset_userdata('awal_periode');
      $this->session->unset_userdata('akhir_periode');
      redirect($_SERVER["HTTP_REFERER"]);
    }

    $classify = collect([
      ["kode" => "KPA", "name" => "Ketua"],
      ["kode" => "WKPA", "name" => "Wakil Ketua"],
      ["kode" => "SPA", "name" => "Sekretaris"],
      ["kode" => "PPA", "name" => "Panitera"],
      ["kode" => "SK", "name" => "Surat Keputusan"],
    ]);

    if ($classify->contains($kode)) {
      $this->session->set_flashdata("notif", "Klasifikasi tidak ditemukan");
      return redirect('/');
    }
    template('template', 'surat_keluar/surat_keluar_klasifikasi', $classify->where("kode", $kode)->first());
  }
}
