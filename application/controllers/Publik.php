<?php

defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . 'models/SuratMasuk.php';
include_once APPPATH . 'models/IdentitasPublik.php';

class Publik extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (count($_GET) > 0) {
            set_status_header(404);
            exit("Please do not try anything");
        }
    }

    function index()
    {
        if (count($_FILES) > 0) {
            set_status_header(404);
            exit("Please do not try anything");
        }
        $this->load->view('publik/surat_masuk');
    }

    private function validate()
    {
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules(
            'asal',
            'Asal Surat',
            'required|xss_clean|max_length[124]'
        );
        $this->form_validation->set_rules(
            'nomor_surat',
            'Nomor Surat',
            'required|xss_clean|max_length[191]'
        );
        $this->form_validation->set_rules(
            'tanggal_surat',
            'Nomor Surat',
            'required|xss_clean|max_length[10]'
        );
        $this->form_validation->set_rules(
            'tanggal_diterima',
            'Tanggal Diterima',
            'required|xss_clean|max_length[10]'
        );
        $this->form_validation->set_rules(
            'perihal',
            'Perihal Surat',
            'required|xss_clean|max_length[124]'
        );
        $this->form_validation->set_rules(
            'ringkasan_isi',
            'Ringkasan Surat',
            'required|xss_clean|max_length[256]'
        );
        $this->form_validation->set_rules(
            'catatan',
            'Catatan Surat',
            'required|xss_clean|max_length[124]'
        );


        if ($this->form_validation->run() == FALSE) {

            throw new Exception("Error While Validating Data. Error : " . validation_errors());
        }

        return $this->input->post();
    }

    private function upload()
    {
        if (
            !file_exists($_FILES['file']['tmp_name'])
            || !is_uploaded_file($_FILES['file']['tmp_name'])
        ) {
            return null;
        }


        $config['upload_path'] = './hasil/surat_masuk/';
        $config['allowed_types'] = 'jpeg|jpg|png|docx|doc|pdf';
        $config['max_size']  = '2048';
        $config['file_name']  = time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            throw new Exception($this->upload->display_errors());
        }

        return $this->upload->data('file_name');
    }

    public function save_identitas()
    {
        try {
            $this->load->helper('security');
            $this->load->library('form_validation');

            $this->form_validation->set_rules(
                'nama',
                'Nama Pengirim',
                'required|xss_clean|max_length[124]'
            );
            $this->form_validation->set_rules(
                'nomor_telepon',
                'Nomor Telepon',
                'required|xss_clean|max_length[20]'
            );

            if ($this->form_validation->run() == FALSE) {
                throw new Exception("Error While Validating Data. Error : " . validation_errors());
            }


            $data = [
                "nama" => htmlspecialchars($this->input->post("nama"), ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED),
                "nomor_telepon" => htmlspecialchars($this->input->post("nomor_telepon"), ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED),
                "ip_forward" => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 'no ip forward',
                "remote_addr" => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'no remote',
                "platform" => isset($_SERVER['HTTP_SEC_CH_UA']) ? $_SERVER['HTTP_SEC_CH_UA'] : 'no platform',
                "http_referer" => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'no ref',
            ];

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // die;

            $iden = IdentitasPublik::firstOrNew(['nomor_telepon' => $data['nomor_telepon']]);
            $iden->nama = $data['nama'];
            $iden->ip_forward = $data['ip_forward'];
            $iden->remote_addr = $data['remote_addr'];
            $iden->platform = $data['platform'];
            $iden->http_referer = $data['http_referer'];

            $iden->save();

            $this->session->set_userdata('nama_iden_publik', $iden->nama);
            $this->session->set_userdata('id_iden_publik', $iden->id);


            redirect('/publik');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function simpan()
    {
        try {
            $data = $this->validate();

            $filename = $this->upload();

            $model = SuratMasuk::create([
                'nomor_surat' => $data['nomor_surat'],
                'tanggal_surat' => $data['tanggal_surat'],
                'asal' => $data['asal'],
                'kode_surat' => $data['kode_surat'],
                'tanggal_diterima' => $data['tanggal_diterima'],
                'perihal' => $data['perihal'],
                'ringkasan_isi' => $data['ringkasan_isi'],
                'catatan' => $data['catatan'],
                'file' => $filename
            ]);

            $wanotif = new Wanotif([
                'number' => "6281287285608",
                'text' => "*Notifikasi Surat Masuk.* Surat masuk dari $model->asal. Nomor surat $model->nomor_surat. Perihal $model->perihal. Silahkan buat disposisi anda dengan menekan link ini: " . base_url('/mobile/redirect?page=surat_masuk&id=' . $model->id),
            ]);

            $wanotif->send();

            IdentitasPublik::where("id", $this->session->userdata('id_iden_publik'))->update(['surat_masuk_id' => $model->id]);

            http_response_code(201);
            echo json_encode([
                'message' => 'Berhasil Mengirim Data',
                'status' => 'Berhasil'
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);

            echo json_encode([
                'message' => $this->form_validation->error_array(),
                'status' => $th->getMessage(),
            ], JSON_PRETTY_PRINT);
        }
    }

    public function reset()
    {
        $this->session->sess_destroy();
        redirect('/publik');
    }
}
