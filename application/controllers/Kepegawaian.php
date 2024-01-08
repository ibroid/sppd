<?php
require_once APPPATH . "models/MasterPegawai.php";
require_once APPPATH . "models/PejabatPelaksana.php";
require_once APPPATH . "models/Jabatan.php";
class Kepegawaian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        template('template', 'kepegawaian/pegawai', [
            'jabatan' => $this->db->get('jabatan')->result(),
            'golongan' => $this->db->get('golongan')->result(),
            'data' => MasterPegawai::select('master_pegawai.*')->where('master_pegawai.aktif', 1)->join('jabatan', 'jabatan.id', '=', 'master_pegawai.jabatan_id')->orderBy('jabatan.atasan_langsung')->get()
        ]);
    }
    public function pegawai()
    {
        if ($this->input->method() == 'post') {

            MasterPegawai::updateOrCreate([
                'id' => !request('id') ? floatval(MasterPegawai::max('id')) + 1 : request('id'),
            ], [
                'nama' => str_replace("'", "`", request('nama')),
                'nip' => request('nip') == '0' ? '' : request('nip'),
                'jabatan_id' => request('jabatan_id'),
                'golongan_id' => request('golongan_id'),
                'nomor_telepon' => request('nomor_telepon'),
            ]);

            $this->session->set_flashdata('notif', 'Pegawai Berhasil Diperbaharui');
            redirect('kepegawaian');
        }
    }

    public function hapus_pegawai($id)
    {
        $pg = MasterPegawai::findOrFail($id);
        $pg->aktif = 0;
        $pg->deleted_at = carbon()->now();
        $pg->save();
        $this->session->set_flashdata('notif', 'Pegawai Berhasil Dihapus');
        redirect('kepegawaian');
    }
    public function plh()
    {
        if (isset($_POST['nama_pejabat'])) {
            PejabatPelaksana::create(request());
            $this->session->set_flashdata('notif', 'Pejabat Pelaksana Harian Berhasil Ditambahkan');
            redirect('kepegawaian/plh');
        }
        template('template', 'kepegawaian/plh', [
            'pegawai' =>  MasterPegawai::select('master_pegawai.*')->where('master_pegawai.aktif', 1)->join('jabatan', 'jabatan.id', '=', 'master_pegawai.jabatan_id')->orderBy('jabatan.id')->get(),
            'plh' => PejabatPelaksana::orderBy('created_at', 'DESC')->get()
        ]);
    }
    public function hapus_plh($id)
    {
        $plh = PejabatPelaksana::findOrFail($id);
        $plh->delete();
        $this->session->set_flashdata('notif', 'Pejabat Pelaksana Harian Berhasil Dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function jabatan()
    {
        if (must_post()) {
            Jabatan::updateOrCreate(
                [
                    'id' => (request('id') !== '') ? request('id') : floatval(Jabatan::max('id'))  + 1
                ],
                [
                    'nama_jabatan' => request('nama_jabatan'),
                    'atasan_langsung' => request('atasan_langsung'),
                    'atasan_pemberi_izin' => request('atasan_pemberi_izin')
                ]
            );
            $this->session->set_flashdata('notif', 'Jabatan Baru Berhasil Ditambahkan');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        template('template', 'kepegawaian/jabatan', [
            'data' =>  Jabatan::get()
        ]);
    }
    public function hapus_jabatan($id)
    {
        $jab = Jabatan::findOrFail($id);
        $jab->delete();
        $this->session->set_flashdata('notif', 'Jabatan Baru Berhasil Dihapus');
        return redirect($_SERVER['HTTP_REFERER']);
    }
    public function save_profile()
    {
        if (!must_post()) {
            show_404();
            exit();
        }
        try {
            if (auth()->check() == null) {
                MasterPegawai::create(request() + ['aktif' => 1]);
            } else {
                MasterPegawai::where('id', auth()->pegawai['id'])
                    ->update(request());
            }
            $this->session->set_flashdata('notif_pegawai', 'Berhasill menyimpan data. Perlu login ulang untuk melihat perubahan apabila merubah data sendiri');
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif_pegawai', 'Gagal :' . $th->getMessage());
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function import()
    {
    }
}
