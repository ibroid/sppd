<?php

require_once APPPATH . "models/Jabatan.php";
require_once APPPATH . "models/SuratDinas.php";

class Debug extends CI_Controller
{
    public function index()
    {
        // echo '<pre>';
        echo json_encode(SuratDinas::with('surat_tugas.pegawai')->where(['id' => 56])->first()->toArray(), JSON_PRETTY_PRINT);
    }
}
