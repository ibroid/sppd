<?php

require_once APPPATH . "models/SuratTugas.php";
require_once APPPATH . "models/Biaya.php";
require_once APPPATH . "models/PengeluaranRiil.php";
class Keuangan extends CI_Controller
{
    public function index()
    {
        template('template', 'surat_tugas/keuangan', [
            'data' => SuratDinas::latest()->get()
        ]);
    }

    public function biaya_spd()
    {
        $data = Biaya::where('surat_dinas_id', request('id'))->get();
        if (request('need') == 'TABLE_ELEMENT') {

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";

            return $this->load->view('component/table_biaya', ['data' => $data]);
        } else if (request('need') == 'JSON') {
            echo json_encode($data);
        }
    }

    public function pengeluaran_riil()
    {
        $data = PengeluaranRiil::where('surat_dinas_id', request('id'))->get();
        if (request('need') == 'TABLE_ELEMENT') {

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";

            return $this->load->view('component/table_pengeluaran', ['data' => $data]);
        } else if (request('need') == 'JSON') {
            echo json_encode($data);
        }
    }
}
