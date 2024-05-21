<?php
defined('BASEPATH') or exit("Kuya Batok");

include_once APPPATH . 'models/SuratTemplate.php';

class Generate extends CI_Controller
{
    public function save_template()
    {
        try {
            $data = [
                'nama_template' => request('nama_template'),
                'keterangan' => request('keterangan'),
                'jenis_template' => request('jenis_template')
            ];

            if (!isset($_POST['id'])) {
                $data['filename'] = $this->upload_template();
            } else {
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $data['filename'] = $this->upload_template();
                }
            }

            // print_r($data);
            // die;
            $save = !isset($_POST['id']) ? SuratTemplate::create($data) : SuratTemplate::where('id', request('id'))->update($data);

            echo json_encode([
                'status' => 'Berhasil',
                'message' => 'Template Berhasil Ditambahkan'
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            echo json_encode([
                'status' => 'Gagal',
                'message' => $th->getMessage()
            ]);
            exit();
        }
    }

    private function upload_template()
    {

        $config['upload_path'] = './template/uploads';
        $config['allowed_types'] = 'docx';
        $config['max_size']  = '2048';
        $config['filename'] = str_replace(' ', '_', strtolower(request('nama_template')));

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            throw new Error($this->upload->display_errors());
        }

        return $this->upload->data('file_name');
    }

    public function delete_template()
    {
        try {
            // file_get_contents("php://input")
            $templateSurat = SuratTemplate::find(request('id'));

            if (!$templateSurat) {
                throw new Exception("Template Surat tidak ditemukan", 1);
            }

            $this->delete_file_template($templateSurat->filename);

            $templateSurat->delete();

            echo json_encode([
                'status' => 'Berhasil',
                'message' => 'Aksi Berhasil dijalankan'
            ]);
        } catch (\Throwable $th) {
            http_response_code(500);

            echo json_encode([
                'status' => 'Gagal',
                'message' => 'Terjadi Kesalahan :' . $th->getMessage()
            ]);
        }
    }

    private function delete_file_template($filename)
    {
        $fullpath = FCPATH . 'template/uploads/' . $filename;
        if (file_exists($fullpath) && is_writable($fullpath)) {
            if (unlink($fullpath)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
