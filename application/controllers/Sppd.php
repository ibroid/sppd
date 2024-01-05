<?php
include_once APPPATH . 'models/SuratTugas.php';
include_once APPPATH . 'models/Biaya.php';
include_once APPPATH . 'models/PengeluaranRiil.php';
include_once APPPATH . 'models/PejabatPelaksana.php';
class Sppd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (auth()->check() == null) {
            redirect('auth');
        }
    }
    public function index()
    {
        template('template', 'sppd/index', [
            'surattugas' => SuratTugas::orderBy('created_at', 'DESC')->get(),
        ]);
    }
    public function buat($par = '')
    {
        if ($par) {
            if (SuratDinas::where('surat_tugas_id', $par)->first()) {
                $this->session->set_flashdata('notif', 'Surat Tugas ini Sudah tersedia SPPD');
                redirect('sppd/daftar');
            } else {
                template('template', 'sppd/buat', [
                    'surattugas' => SuratTugas::findOrFail($par)
                ]);
            }
        } else {
            SuratDinas::create(request());
            redirect('sppd/daftar');
        }
    }
    public function daftar()
    {
        $data = SuratDinas::orderBy('created_at', 'DESC');
        if (isset($_POST['tanggal'])) {
            $data->whereDate('created_at', request('tanggal'));
        } else {
            // $data->whereDate('created_at', carbon()->now());
        }
        template('template', 'sppd/daftar', [
            'suratdinas' => $data->get(),
            'plh' => PejabatPelaksana::orderBy('created_at', 'DESC')->get()
        ]);
    }
    public function biaya($id)
    {
        if (isset($_POST['biaya'])) {
            for ($i = 0; $i < count(request('biaya')); $i++) {
                Biaya::updateOrCreate([
                    'keperluan' => request('keperluan')[$i],
                ], [
                    'surat_dinas_id' => $id,
                    'keterangan' => request('keterangan')[$i],
                    'biaya' => request('biaya')[$i],
                    'jumlah' => request('jumlah')[$i],
                ]);
            }

            $this->session->set_flashdata('notif', 'Rincian Biaya Berhasil Dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            template('template', 'sppd/biaya', [
                'data' => Biaya::where('surat_dinas_id', $id)->get()
            ]);
        }
    }
    public function hapus_biaya($id)
    {
        $biaya = Biaya::find($id);
        $biaya->delete();
        $this->session->set_flashdata('notif', 'Tambah Rincian Biaya Berhasil');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function tanggal_pencairan()
    {
        try {
            $sd = SuratDinas::find(request('id'));
            $sd->tanggal_pencairan = request('tanggal_pencairan');
            $sd->save();
            echo json_encode(['status' => 200]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function riil($id)
    {
        if (isset($_POST['submit'])) {

            PengeluaranRiil::create([
                'id' => PengeluaranRiil::max('id') + 1,
                'surat_dinas_id' => $id,
                'keperluan' => request('keperluan'),
                'harga' => request('harga'),
                'jumlah' => request('jumlah'),
                'keterangan' => request('keterangan'),
                'tanggal' => request('tanggal'),
            ]);
            $this->session->set_flashdata('notif', 'Pengeluaran Riil Berhasil Ditambahkan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        template('template', 'sppd/riil', [
            'data' => PengeluaranRiil::where('surat_dinas_id', $id)->orderBy('created_at', 'DESC')->get(),
            'id' => $id
        ]);
    }
    public function hapus_riil($id)
    {
        $data = PengeluaranRiil::find($id);
        $data->delete();
        $this->session->set_flashdata('notif', 'Pengeluaran Riil berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit($id = null)
    {
        if (isset($_POST['id'])) {
            SuratDinas::where('id', request('id'))->update(request());
            $this->session->set_flashdata('notif', 'Surat Dinas berhasil diperbaharui');
            redirect('sppd/daftar');
        }
        if ($id) {
            template('template', 'sppd/edit', [
                'sd' => SuratDinas::findOrFail($id)
            ]);
        }
    }
    public function hapus()
    {
        if ($this->input->method() == 'get') {
            return show_404();
        }
        header('Content-Type: application/json');
        try {
            $sd = SuratDinas::find(request('id'));
            foreach ($sd->biaya as $sdb) {
                $sdb->delete();
            }
            foreach ($sd->riil as $sdr) {
                $sdr->delete();
            }
            $sd->delete();
            echo json_encode([
                'title' => 'Sukses',
                'icon' => 'success',
                'text' => 'Hapus Berhasil.'
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => $th->getMessage()
            ]);
        }
    }

    public function datatable()
    {
        if (!must_post()) {
            show_404();
            exit;
        }

        $kodeSurat = $this->db->get('kode_surat')->result();

        $this->load->helper('element');
        $this->load->model('SuratDinasDatatable');
        $lists = $this->SuratDinasDatatable->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($lists as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = format_hari_tanggal($list->tanggal_berangkat) . '<br>' . $list->tempat_berangkat;
            $row[] = format_hari_tanggal($list->tanggal_pulang) . '<br>' . $list->tempat_tujuan;
            $row[] = rupiah($this->sumBiaya($list->id));
            $row[] = $this->countPegawai($list->surat_tugas_id);
            // $row[] = $list->nomor_surat;
            $row[] = $this->load->view('sppd/components/input_nomor_surat', ['data' => $list, 'kode' => $kodeSurat], TRUE);
            $row[] = $this->load->view('sppd/components/button_edit_pegawai', [
                'data' => SuratDinas::with('surat_tugas.pegawai')->where(['id' => $list->id])->first()->toArray()
            ], TRUE);
            $row[] = $this->load->view('sppd/components/dropdown_aksi', ['v' => $list], TRUE);

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->SuratDinasDatatable->count_all(),
            "recordsFiltered" => $this->SuratDinasDatatable->count_filtered(),
            "data" => $data,
        );
        header('Content-Type: application/json');
        $this->output->set_output(json_encode($output));
    }

    private function countPegawai($id)
    {
        $qry = $this->db->query("SELECT COUNT(*) as total FROM pegawai WHERE surat_tugas_id = $id")->row();
        if ($qry) {
            return $qry->total;
        }
        return 0;
    }

    private function sumBiaya($id)
    {
        $qry = $this->db->query("SELECT SUM(biaya) as total FROM biaya WHERE surat_dinas_id = $id")->row();
        if ($qry) {
            return $qry->total;
        }
        return 0;
    }
}
