<?php

defined('BASEPATH') or exit('Kuya Batok');
require_once APPPATH . 'models/MasterPegawai.php';
require_once APPPATH . 'models/User.php';
require_once APPPATH . 'models/Role.php';
require_once APPPATH . 'models/AccessMenu.php';

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if (auth()->check() == null) {
            redirect('auth');
        }
    }

    public function index()
    {
        template('template', 'user/profil', [
            'jabatan' => $this->db->get('jabatan')->result(),
            'golongan' => $this->db->get('golongan')->result(),
            'pegawai' => MasterPegawai::find(auth()->pegawai['id']),
            'user' => User::find(auth()->user['id'])
        ]);
    }
    public function save()
    {
        if (!must_post()) {
            show_404();
            exit();
        }
        try {
            User::create([
                'username' => request('username'),
                'password' => password_hash(request('password'), PASSWORD_BCRYPT),
                'pegawai_id' => request('pegawai_id'),
                'role_id' => request('role_id'),
            ]);
            $this->session->set_flashdata('notif_pegawai', 'Berhasil Menambah User');
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif_pegawai', 'Gagal :' . $th->getMessage());
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function change_credential()
    {
        if (!must_post()) {
            show_404();
            exit();
        }
        if (auth()->check() == null) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        try {
            if (!isset($_POST['id'])) {
                $user = User::find(auth()->user['id']);
            } else {
                $user = User::find(request('id'));
            }
            $user->username = request('username');
            if (request('password') != null) {
                $user->password = password_hash(request('password'), PASSWORD_BCRYPT);
            }
            $user->save();
            $this->session->set_flashdata('notif_pengguna', 'Berhasil Menyimpan Userdata');
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif_pengguna', 'Gagal :' . $th->getMessage());
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function role($id = null)
    {
        $role = Role::with('menu')->find($id);
        echo json_encode($role);
    }
    public function update_role()
    {
        if (!must_post()) {
            show_404();
            exit();
        }
        try {
            $user = User::find(request('id'));
            $old_role = $user->role->role_name;
            $role = Role::find(request('role_id'));
            $user->role_id = request('role_id');
            $user->save();
            // echo '<pre>';
            // print_r($user);
            // die;
            echo json_encode([
                'title' => 'Sukses',
                'text' => 'Role berhasil dirubah dari ' .  $old_role . ' menjadi ' . $role->role_name,
                'icon' => 'success'
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'title' => 'Terjadi Kesalahan',
                'text' => $th->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
    public function edit_role_and_access()
    {
        if (!must_post()) {
            show_404();
            exit;
        }
        try {
            $role = Role::find(request('id'));
            foreach ($role->accessible_menu as $key => $value) {
                $value->delete();
            }
            foreach (request('access_menu') as $n) {
                AccessMenu::create([
                    'role_id' => request('id'),
                    'menu_id' => $n,
                ]);
            }
            $role->role_name = request('role_name');
            $role->save();
            $this->session->set_flashdata('notif', 'Update role berhasil');
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif', $th->getMessage());
        }

        redirect('/app/role');
    }
    public function add_role()
    {

        if (!must_post()) {
            show_404();
            exit;
        }
        try {
            $role = Role::create([
                'role_name' => request('role_name')
            ]);
            foreach (request('access_menu') as $n) {
                AccessMenu::create([
                    'role_id' => $role->id,
                    'menu_id' => $n,
                ]);
            }
            $this->session->set_flashdata('notif', 'Berhasil menambah role baru');
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif', $th->getMessage());
        }
        redirect('/app/role');
    }
}
