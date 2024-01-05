<?php
require_once APPPATH . "models/User.php";
class Auth extends CI_Controller
{
    public function index()
    {
        return $this->load->view('login');
    }
    public function login()
    {
        if (isset($_POST['username'])) {
            $user = User::where('username', request('username'))->first();
            if ($user) {
                if (password_verify(request('password'), $user->password)) {
                    $this->session->set_userdata([
                        'spd_user' => $user->toArray(),
                        'spd_pegawai' => $user->pegawai->toArray(),
                        'spd_is_loggin' => true
                    ]);
                    $this->session->set_flashdata('notif', 'Selamat Datang ' . $user->pegawai->nama);
                    redirect('app');
                } else {
                    $this->session->set_flashdata('notif', 'Password Salah');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('notif', 'User Salah');
                redirect('auth');
            }
        }
    }
    public function end()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
    public function debug()
    {
        echo password_hash('imal', PASSWORD_DEFAULT);
    }
}
