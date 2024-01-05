<?php

require_once APPPATH . 'models/SuratMasuk.php';
require_once APPPATH . 'models/Jabatan.php';
require_once APPPATH . 'models/MasterPegawai.php';
require_once APPPATH . 'models/Disposisi.php';

class Disposisi_surat extends CI_Controller
{
    public function order()
    {
        try {
            // $data = Jabatan::join('disposisi_order', 'jabatan.id', 'disposisi_order.jabatan_id')->where('order_priority', 1)->get()->toArray();
            $data = Jabatan::get()->toArray();

            echo json_encode([
                'status' => 'ok',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                'status' => 'ok',
                'data' => $th->getMessage()
            ]);
        }
    }

    public  function save()
    {
        if ($this->input->method() != 'post') {
            return http_response_code(404);
        }

        try {
            $pegawai = MasterPegawai::where([
                'id' => $this->input->post('kepada'),
                'aktif' => 1
            ])->first();

            if (!$pegawai) {
                throw new Error("Pegawai Tidak ada");
            }

            // print_r($pegawai);
            // die;

            $data = Disposisi::create([
                'surat_masuk_id' => $this->input->post('surat_masuk_id'),
                'pegawai_id' => $pegawai->id,
                'nomor_agenda' => floatval($this->input->post('nomor_agenda')),
                'isi_disposisi' => $this->input->post('isi_disposisi')
            ]);

            http_response_code(201);
            echo json_encode([
                'status' => 'Berhasil',
                'data' =>  $data->with('pegawai.jabatan')
            ]);
        } catch (\Throwable $th) {
            // throw $th;
            // http_response_code(400);
            echo json_encode([
                'status' => 'Failed',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function list($id = null)
    {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        $data = Disposisi::with('pegawai.jabatan')->where('surat_masuk_id', $id)->get();
        echo json_encode([
            'status' => 'Berhasil',
            'data' => $data
        ]);
    }

    public function cetak()
    {
        if ($this->input->method() != 'post') {
            http_response_code(404);
            exit();
        }
        $data = Disposisi::with('surat_masuk')->where('surat_masuk_id', request('id'))->get();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/template_disposisi.docx');

        $templateProcessor->setImageValue('logo', [
            'path' => './logo/' . pengaturan()->logo_satker,
            'width' => 50, 'height' => 50, 'ratio' => false
        ]);

        $templateProcessor->cloneRow('disposisi_lanjutan', count($data) - 1);
        $templateProcessor->cloneRow('disposisi_pertama', count($data) - 1);

        // $templateProcessor->setValue('disposisi_pertama#1', 'Yth. ' . $data[0]->pegawai->jabatan->nama_jabatan . '. ' . $data[0]->isi_disposisi);

        $no = 1;
        foreach ($data as $i => $v) {
            if ($v->pegawai->jabatan_id != 1) {
                $templateProcessor->setValue("disposisi_pertama#$i", "-" . $v->isi_disposisi);
                $templateProcessor->setValue("disposisi_lanjutan#$i", "Yth. " . $v->pegawai->jabatan->nama_jabatan);
            }
        }

        $templateProcessor->setValues([
            'kode_surat' => $data[0]->surat_masuk->kode_surat,
            'tanggal_surat' => format_tanggal($data[0]->surat_masuk->tanggal_surat),
            'nomor_surat' => $data[0]->surat_masuk->nomor_surat,
            'asal_surat' => $data[0]->surat_masuk->asal,
            'isi_ringkas' => $data[0]->surat_masuk->ringkasan_isi,
            'tanggal_diterima' => format_tanggal($data[0]->surat_masuk->tanggal_diterima),
            'no_ag' => $data[0]->nomor_agenda,
            'nama_pegawai' => $data[0]->pegawai->nama,
            'nama_ketua' => pengaturan()->nama_ketua,
            'nip_ketua' => pengaturan()->nip_ketua,
        ]);

        $filename = time() . '.docx';
        $templateProcessor->saveAs(FCPATH . 'hasil/' . $filename);

        download_hasil('disposisi', $filename);
    }
}
