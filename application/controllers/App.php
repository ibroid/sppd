<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once APPPATH . 'models/User.php';
include_once APPPATH . 'models/Menu.php';
include_once APPPATH . 'models/Role.php';
include_once APPPATH . 'models/Instrumens.php';
class App extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (auth()->check() == null) {
            redirect('auth');
        }

        $this->load->database();
    }
    public function index()
    {
        $this->load->database();
        $data['users'] = User::all();
        $data['blm_ada_disposisi'] = $this->db->query("SELECT * FROM surat_masuk as a WHERE NOT EXISTS(SELECT * FROM disposisi WHERE surat_masuk_id = a.id)")->result();
        $data['surat_masuk'] = $this->db->query("SELECT COUNT(*) as total FROM surat_masuk")->row();
        $data['surat_keluar'] = $this->db->query("SELECT COUNT(*) as total FROM surat_keluar")->row();
        $data['instrumen'] = $this->db->query("SELECT COUNT(*) as total FROM instrumen")->row();
        $data['spd'] = $this->db->query("SELECT COUNT(*) as total FROM surat_tugas")->row();
        $data['surat_tanpa_nomor'] = $this->db->query("SELECT * FROM surat_keluar WHERE nomor_surat IS NULL")->result();
        // echo '<pre>';
        // print_r($data['instrumens']);
        template('template', 'home', $data);
    }
    public function setting()
    {
        if (isset($_POST['name'])) {
            Pengaturan::where('name', request('name'))->update([
                'value' => request('value')
            ]);
            echo json_encode(['status' => 200]);
        } else {
            template('template', 'setting', [
                'st' => pengaturan()
            ]);
        }
    }
    public function logo()
    {

        $config['upload_path'] = "./logo/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']  = '1024';
        $config['file_name'] = time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('logo')) {
            echo json_encode(['status' => 200, 'msg' =>  $this->upload->display_errors()]);
        } else {
            Pengaturan::where('name', 'logo_satker')->update([
                'value' => $this->upload->data('file_name')
            ]);
            echo json_encode(['status' => 200, 'msg' =>  'Upload Berhasil']);
        }
    }
    public function pengguna()
    {
        $pegawai = $this->db->get_where('master_pegawai', ['aktif' => 1])->result();
        $res_pegawai = [];

        foreach ($pegawai as $key => $value) {
            array_push($res_pegawai, [
                'label' => $value->nama,
                'value' => $value->id,
            ]);
        }

        // print_r($res_pegawai);
        template('template', 'setting_user', [
            'user' => User::latest()->get(),
            'menu' => Menu::all(),
            'roles' => $this->db->get('roles')->result(),
            'pegawai' => json_encode($res_pegawai)
        ]);
    }
    public function role()
    {
        template('template', 'setting_role', [
            'roles' => Role::all(),
            'menu' => Menu::all(),
            'menu_name_only' => $this->db->select('id,menu_name')->from('menus')->get()->result()
        ]);
    }

    public function notification_config()
    {
        template('template', 'notification_config', []);
    }

    public function notif_test()
    {
        if (!must_post()) {
            set_status_header(404);
            exit();
        }

        try {
            $data = array(
                'chatId' => request("nomor_telepon"),
                'text' => 'TEST NOTIFIKASI DARI APLIKASI SURAT',
                'session' => 'default'
            );

            $data_string = json_encode($data);

            $ch = curl_init($_ENV["WA_API_URL"] . "/api/sendText");

            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            ));

            $result = curl_exec($ch);

            curl_close($ch);

            // Menampilkan hasil
            // prindie($result);
            $this->session->set_flashdata("notif", $result);
        } catch (\Throwable $th) {
            //throw $th;
            $this->session->set_flashdata("notif", $th->getMessage());
        }


        redirect('/app/notification_config');
    }
}
