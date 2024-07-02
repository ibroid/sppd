<?php

require_once APPPATH . 'models/SuratMasuk.php';
require_once APPPATH . 'models/Jabatan.php';
class Surat_masuk extends CI_Controller
{
    function show($id = 0)
    {
        try {
            echo json_encode(SuratMasuk::findOrFail($id));
        } catch (\Throwable $th) {
            http_response_code(404);
        }
    }

    function list()
    {
        $data = SuratMasuk::where('tanggal_diterima', isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'))->orderBy('tanggal_diterima', 'DESC')->limit(20);

        echo json_encode($data->get());
    }

    public function save()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    public function download()
    {
        $data = SuratMasuk::find($this->input->post('id'));

        $filename = str_replace(' ', '_', $data->perihal) . '.' . explode('.', $data->file)[1];

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        ob_clean();
        flush();
        readfile(FCPATH . 'hasil/surat_masuk/' . $data->file);
        exit();
    }
}
