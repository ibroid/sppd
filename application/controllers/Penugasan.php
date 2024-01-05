<?php

require_once APPPATH . 'models/SuratTugas.php';
require_once APPPATH . 'models/Pegawai.php';
require_once APPPATH . 'models/MasterPegawai.php';
require_once APPPATH . 'models/PejabatPelaksana.php';
class Penugasan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (auth()->check() == null) {
            redirect('auth');
        }
    }

    public function index()
    {
        template('template', 'surat_tugas/index', [
            'pegawai' => MasterPegawai::where('aktif', 1)->with('jabatan')->get(),
            'jabatan' => $this->db->get('jabatan')->result(),
            'golongan' => $this->db->get('golongan')->result(),
        ]);
    }
    public function tambah()
    {
        $surattugas = SuratTugas::create([
            'menimbang' => request('menimbang'),
            'dasar_hukum' => request('dasar_hukum'),
            'tujuan' => request('tujuan'),
            'tugas' => request('tugas'),
            'perihal' => request('perihal'),
            'tanggal_surat' => date('Y-m-d'),
        ]);

        for ($i = 0; $i < count(request('nama')); $i++) {
            Pegawai::create([
                'nama' => request('nama')[$i],
                'jabatan' => request('jabatan')[$i],
                'pangkat' => request('pangkat')[$i],
                'golongan' => request('golongan')[$i],
                'nip' => request('nip')[$i],
                'surat_tugas_id' => $surattugas->id
            ]);
        }
        redirect('penugasan/daftar');
    }

    public function daftar()
    {
        template('template', 'surat_tugas/daftar', [
            // 'surattugas' => SuratTugas::orderBy('created_at', 'DESC')->get(),
            'jabatan' => $this->db->get('jabatan')->result(),
            'golongan' => $this->db->get('golongan')->result(),
            'plh' => PejabatPelaksana::get(),
            // 'kode' => $this->db->get('kode_surat')->result(),
        ]);
    }

    public function datatable()
    {
        if (!must_post()) {
            show_404();
            exit;
        }

        $daftarkode =  $this->db->get('kode_surat')->result();

        $this->load->model('SuratTugasDatatable');
        $lists = $this->SuratTugasDatatable->get_datatables();
        $data = array();

        $no = $this->input->post('start');
        foreach ($lists as $list) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $list->perihal;
            $row[] = $list->tujuan;
            $row[] = $list->tugas;
            $row[] = $this->load->view('surat_tugas/components/row_penomoran', [
                'kode' =>  $daftarkode,
                'data' => $list
            ], TRUE);

            $row[] = $this->load->view('surat_tugas/components/row_edit_pegawai', [
                'data' => $list,
                'pegawai' => $this->db->get_where('pegawai', ['surat_tugas_id' => $list->id])->result()
            ], TRUE);

            $row[] = $this->load->view('surat_tugas/components/row_aksi', [
                'data' => $list
            ], TRUE);

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->SuratTugasDatatable->count_all(),
            "recordsFiltered" => $this->SuratTugasDatatable->count_filtered(),
            "data" => $data,
        );
        header('Content-Type: application/json');
        $this->output->set_output(json_encode($output));
    }

    public function edit_pegawai()
    {
        for ($i = 0; $i < count(request('nama')); $i++) {
            if (isset(request('id')[$i])) {
                Pegawai::where('id', request('id')[$i])->update([
                    'nama' => request('nama')[$i],
                    'jabatan' => request('jabatan')[$i],
                    'pangkat' => request('pangkat')[$i],
                    'golongan' => request('golongan')[$i],
                    'nip' => request('nip')[$i],
                ]);
            } else {
                print_r($_POST);
                die;
                Pegawai::create([
                    'nama' => request('nama')[$i],
                    'jabatan' => request('jabatan')[$i],
                    'pangkat' => request('pangkat')[$i],
                    'golongan' => request('golongan')[$i],
                    'nip' => request('nip')[$i],
                    'surat_tugas_id' => request('surat_tugas_id')
                ]);
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function cetak()
    {
        if ($this->input->method() != 'post') {
            http_response_code(404);
            exit;
        }

        $pengaturan = pengaturan();
        $surattugas = SuratTugas::findOrFail(request('id'));

        $templateFile = request('template');

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . "template/$templateFile");

        fetchKopSurat($templateProcessor);

        $templateProcessor->setValues([
            'menimbang' => $surattugas->menimbang,
            'dasar_hukum' => $surattugas->dasar_hukum,
            'tujuan' => $surattugas->tujuan,
            'untuk' => $surattugas->tugas,
            'tanggal_tiba_tujuan' => isset($surattugas->surat_dinas->tanggal_tiba) ? format_tanggal($surattugas->surat_dinas->tanggal_tiba) : format_tanggal(date('Y-m-d')),
            'nomor_surat' => $surattugas->nomor_surat,
        ]);

        $templateProcessor->setValue('referensi_biaya', request('referensi') == 4 ? $pengaturan->referensi_dipa_04 : $pengaturan->referensi_dipa_01);

        $templateProcessor->cloneRow('no', count($surattugas->pegawai));
        foreach ($surattugas->pegawai as $n => $v) {
            ++$n;
            $templateProcessor->setValue('no#' . $n, $n);
            $templateProcessor->setValue('nama_pegawai#' . $n, $v->nama);
            $templateProcessor->setValue('nip_pegawai#' . $n, $v->nip);
            $templateProcessor->setValue('gol_pegawai#' . $n, $v->golongan);
            $templateProcessor->setValue('pangkat_pegawai#' . $n, $v->pangkat);
            $templateProcessor->setValue('jabatan_pegawai#' . $n, $v->jabatan);
        }

        $templateProcessor->setValue('tanggal_sekarang', format_tanggal(date('Y-m-d')));
        $templateProcessor->setImageValue('logo_satker', './logo/' . pengaturan()->logo_satker);

        $penandatangan = request('penandatangan');

        if ($penandatangan) {
            switch ($penandatangan) {
                case 'Wakil':
                    $templateProcessor->setValue('penandatangan', 'Wakil');
                    $templateProcessor->setValue('nama_penandatangan', $pengaturan->nama_wakil);
                    $templateProcessor->setValue('nip_penandatangan', $pengaturan->nip_wakil);
                    break;
                case 'Panitera':
                    $templateProcessor->setValue('penandatangan', 'Panitera');
                    $templateProcessor->setValue('nama_penandatangan', $pengaturan->nama_panitera);
                    $templateProcessor->setValue('nip_penandatangan', $pengaturan->nip_panitera);
                    break;
                case 'Sekretaris':
                    $templateProcessor->setValue('penandatangan', 'Sekretaris');
                    $templateProcessor->setValue('nama_penandatangan', $pengaturan->nama_sekretaris);
                    $templateProcessor->setValue('nip_penandatangan', $pengaturan->nip_sekretaris);
                    break;
                default:
                    if (is_numeric($penandatangan)) {
                        $plh = PejabatPelaksana::find($penandatangan);
                        $templateProcessor->setValue('penandatangan', 'Pejabat Pelaksana harian');
                        $templateProcessor->setValue('nama_penandatangan', $plh->nama_pejabat);
                        $templateProcessor->setValue('nip_penandatangan', $plh->nip_pejabat);
                    } else {
                        $templateProcessor->setValue('penandatangan', 'Ketua');
                        $templateProcessor->setValue('nama_penandatangan', $pengaturan->nama_ketua);
                        $templateProcessor->setValue('nip_penandatangan', $pengaturan->nip_ketua);
                    }
                    break;
            }
        } else {
            $templateProcessor->setValue('penandatangan', 'Ketua');
            $templateProcessor->setValue('nama_penandatangan', $pengaturan->nama_ketua);
            $templateProcessor->setValue('nip_penandatangan', $pengaturan->nip_ketua);
        }

        $filename = "SURAT_TUGAS.docx";
        $templateProcessor->saveAs(FCPATH . "hasil/" . $filename);
        // redirect($fullpathfilename);
        download_hasil("SURAT_TUGAS_" . request('id'), $filename);
    }
    public function delete($id)
    {
        $st = SuratTugas::find($id);

        if ($st->surat_dinas) {
            $this->session->set_flashdata('notif', 'Mohon hapus terlebih dahulu surat dinas yang telah dibuat berdasarkan surat tugas ini');
        } else {
            foreach ($st->pegawai as $p) {
                $p->delete();
            }
            $st->delete();
            $this->session->set_flashdata('notif', 'Surat Tugas Berhasil Dihapus');
        }
        redirect('penugasan/daftar');
    }
    public function surat_tugas_penandatangan()
    {
        if (isset($_POST['penandatangan'])) {
            $this->session->set_flashdata('spd_penandatangan', request('penandatangan'));
            echo json_encode(['status' => 200]);
        } else {
            show_404();
        }
    }

    public function referensi_biaya()
    {
        if (isset($_POST['referensi'])) {
            $this->session->set_flashdata('spd_referensi_biaya', request('referensi'));
            echo json_encode(['status' => 200]);
        } else {
            show_404();
        }
    }
    public function edit($id)
    {
        if (isset($_POST['menimbang'])) {
            SuratTugas::where('id', $id)->update(request());
            $this->session->set_flashdata('notif', 'Surat Tugas Berhasil di Update');
            return redirect('penugasan/daftar');
        }
        template('template', 'surat_tugas/edit', [
            'data' => SuratTugas::findOrFail($id)
        ]);
    }

    public function penomoran()
    {
        template('template', 'surat_tugas/penomoran', [
            'data' => SuratTugas::orderBy('created_at', 'DESC')->get()
        ]);
    }
}
