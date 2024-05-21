<?php

require_once APPPATH . 'models/MasterPegawai.php';
require_once APPPATH . 'models/Instrumens.php';
class Instrumen extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        if (isset($_POST['submit'])) {
            $instrumen = Instrumens::create([
                'maksud' => request('maksud'),
                'tujuan' => request('tujuan'),
                'tanggal_penugasan' => request('tanggal_penugasan'),
                'perihal' => request('perihal')
            ]);

            foreach (request('pegawai') as $p) {
                $this->db->insert('ins_pegawai', [
                    'instrumen_id' => $instrumen->id,
                    'pegawai_id' => $p
                ]);
            }

            $this->session->set_flashdata('notif', 'Instrumen Penugasan Berhasil Dibuat');

            return redirect('instrumen/daftar');
        }
        template('template', 'instrumen/buat', [
            'pegawai' => MasterPegawai::where('aktif', 1)->get()
        ]);
    }

    public function daftar()
    {
        template('template', 'instrumen/daftar', [
            'instrumen' => Instrumens::orderBy('created_at', 'DESC')->get()
        ]);
    }
    public function delete($id = '')
    {
        if (!$id) {
            return show_404();
        }

        $ins = Instrumens::findOrFail($id);
        $ins->delete();

        $this->db->delete('ins_pegawai', [
            'instrumen_id' => $id
        ]);

        $this->session->set_flashdata('notif', 'Instrumen Penugasan Berhasil Dihapus');

        redirect('instrumen/daftar');
    }

    public function cetak($id = '')
    {
        if (!$id) {
            return show_404();
        }

        $pengaturan = pengaturan();

        $ins = Instrumens::findOrFail($id);

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . "template/template_instrumen.docx");

        $jumlahPegawai = count($ins->pegawai->toArray());
        $templateProcessor->cloneBlock('block_name', $jumlahPegawai, true, true);

        foreach ($ins->pegawai->toArray() as $n => $v) {
            ++$n;
            $templateProcessor->setValue("no#" . $n, $n);
            $templateProcessor->setValue("nama#" . $n, $v['nama']);
        }

        // $templateProcessor->setValues([]);

        echo "<pre>";
        print_r($templateProcessor->getVariableCount());
        echo "</pre>";

        $templateProcessor->setValues([
            'tujuan' => $ins->tujuan,
            'maksud' => $ins->maksud,
            'perihal' => $ins->perihal,
            'tanggal_penugasan' => format_hari_tanggal($ins->tanggal_penugasan),
            'tanggal_sekarang' => format_tanggal(date('Y-m-d')),
        ]);
        $penandatangan = $this->session->flashdata('spd_penandatangan');
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

        $fullpathfilename = "hasil/INSTRUMEN_PENUGASAN_" . str_replace(' ', '_', $ins->tujuan) . '.docx';
        $templateProcessor->saveAs(FCPATH . $fullpathfilename);
        redirect($fullpathfilename);
    }
}
