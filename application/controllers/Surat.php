<?php
defined("BASEPATH") or exit('Kuya batok');

include_once APPPATH . 'models/SuratMasuk.php';
include_once APPPATH . 'models/SuratKeluar.php';
include_once APPPATH . 'models/SuratKeluarRelation.php';
include_once APPPATH . 'models/SuratTugas.php';
include_once APPPATH . 'models/Disposisi.php';
include_once APPPATH . 'models/SuratTemplate.php';
include_once APPPATH . 'models/IdentitasPublik.php';
include_once APPPATH . 'models/NomorSuratTerakhir.php';

class Surat extends CI_Controller
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
        $this->surat_masuk();
    }
    public function surat_masuk()
    {
        if (isset($_POST['awal']) && isset($_POST['akhir'])) {
            $this->session->set_userdata('sm_awal_periode', request('awal'));
            $this->session->set_userdata('sm_akhir_periode', request('akhir'));
        }


        if (isset($_GET['reset'])) {
            $this->session->unset_userdata('sm_awal_periode');
            $this->session->unset_userdata('sm_akhir_periode');
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $pegawai = $this->db->query("SELECT nama,id FROM master_pegawai")->result();
        // print_r($asal_surat);
        // die;
        $suggest_pegawai = [];

        foreach ($pegawai as $kp => $vp) {
            array_push($suggest_pegawai, [
                'label' => $vp->nama,
                'value' => $vp->id,
            ]);
        }

        template('template', 'persuratan/surat_masuk', [
            'suggest_pegawai' => $suggest_pegawai,
        ]);
    }

    public function save_surat_masuk()
    {
        if (!must_post()) {
            show_404();
            exit;
        }

        $filename = null;
        try {

            if ($_FILES['file']['name']) {

                $config['upload_path'] = './hasil/surat_masuk/';
                $config['allowed_types'] = 'jpeg|jpg|png|docx|doc|pdf';
                $config['max_size']  = '8192';
                $config['file_name']  = time();

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file')) {
                    throw new Exception($this->upload->display_errors(), 1);
                } else {
                    $filename = $this->upload->data('file_name');
                    $this->session->set_flashdata('notif_file', 'Dokumen file berhasil di upload');
                }
            }

            SuratMasuk::create([
                'nomor_surat' => request('nomor_surat'),
                'tanggal_surat' => request('tanggal_surat'),
                'kode_surat' => request('kode_surat'),
                'asal' => request('asal'),
                'tanggal_diterima' => request('tanggal_diterima'),
                'perihal' => request('perihal'),
                'ringkasan_isi' => request('ringkasan_isi'),
                'catatan' => request('catatan'),
                'klasifikasi' => request('klasifikasi'),
                'file' => $filename
            ]);
            $this->session->set_flashdata('notif', 'Surat masuk berhasil disimpan');
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif', $th->getMessage());
        }

        redirect('surat/surat_masuk');
    }
    public function datatable_surat_masuk()
    {
        if (!must_post()) {
            show_404();
            exit;
        }

        $this->load->helper('element');
        $this->load->model('SuratMasukDatatable');
        $lists = $this->SuratMasukDatatable->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($lists as $list) {

            $idenPub = IdentitasPublik::where('surat_masuk_id', $list->id)->first();
            if ($idenPub) {
                $nama = $idenPub->nama;
                $telepon = $idenPub->nomor_telepon;
            } else {
                $nama = null;
                $telepon = null;
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="#" onclick="fetchUbahNrt(' . $list->id . ')" data-bs-toggle="modal" data-bs-target="#modalEditNrt">' . $list->nomor_register . '  <i class="bi bi-pencil"></i><a>' . '<br>' . $list->created_at;
            $row[] = "<ul><li>$list->asal</li><li>$nama ($telepon) </li></ul>";
            $row[] = $list->nomor_surat . '<br>Kode: ' . $list->kode_surat;
            $row[] = format_tanggal($list->tanggal_surat);
            $row[] = $list->perihal . '<details>' . $list->ringkasan_isi . '</details>';
            $row[] = format_tanggal($list->tanggal_diterima) . '<br>Catatan : ' . $list->catatan;
            $row[] = checkDisposisi($list->id, $list->klasifikasi);
            $row[] = checkFileSuratMasuk($list);
            $row[] = '<button onclick="editData(this)" data-json=\'' . json_encode($list, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '\' class="btn btn-warning  btn-sm">Edit</button><button onclick="deleteData(' . $list->id . ')" class="btn btn-danger btn-sm">Hapus</button>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->SuratMasukDatatable->count_all(),
            "recordsFiltered" => $this->SuratMasukDatatable->count_filtered(),
            "data" => $data,
        );
        header('Content-Type: application/json');
        $this->output->set_output(json_encode($output));
    }
    public function update_surat_masuk()
    {
        if (!must_post()) {
            show_404();
            exit;
        }
        if (isset($_FILES['file']) && $_FILES['file']['name']) {
            $config['upload_path'] = './hasil/surat_masuk/';
            $config['allowed_types'] = 'jpeg|jpg|png|docx|doc|pdf';
            $config['max_size']  = '8192';
            $config['file_name']  = time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $this->session->set_flashdata('notif_file', $this->upload->display_errors());
                echo json_encode([
                    'title' => 'Terjadi Kesalahan',
                    'icon' => 'error',
                    'text' => $this->upload->display_errors()
                ]);
            } else {
                $surat = SuratMasuk::find(request('id'));
                $surat->file = $this->upload->data('file_name');
                $surat->save();
                $this->session->set_flashdata('notif_file', 'Dokumen file berhasil diupload');
                echo json_encode([
                    'title' => 'Upload file berhail',
                    'icon' => 'success'
                ]);
            }
        } else {
            // print_r(request());
            // die;
            try {
                SuratMasuk::where('id', request('id'))->update([
                    'nomor_surat' => request('nomor_surat'),
                    'tanggal_surat' => request('tanggal_surat'),
                    'asal' => request('asal'),
                    'kode_surat' => request('kode_surat'),
                    'tanggal_diterima' => request('tanggal_diterima'),
                    'perihal' => request('perihal'),
                    'ringkasan_isi' => request('ringkasan_isi'),
                    'catatan' => request('catatan'),
                    'klasifikasi' => request('klasifikasi'),
                ]);
                $this->session->set_flashdata('notif', 'Data berhasil diperbarui');
            } catch (\Throwable $th) {
                $this->session->set_flashdata('notif', $th->getMessage());
            }
            redirect('/surat/surat_masuk');
        }
    }
    public function hapus_file_surat_masuk($id = null)
    {
        if (must_post()) {
            show_404();
            exit;
        }
        if (!isset($_SERVER['HTTP_REFERER']) or !$id) {
            show_404();
            exit;
        }

        $surat = SuratMasuk::find($id);
        if (file_exists('./hasil/surat_masuk/' . $surat->file)) {
            unlink('./hasil/surat_masuk/' . $surat->file);
        }
        $surat->file = '';
        $surat->save();
        $this->session->set_flashdata('notif_file', 'Dokumen file berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function hapus_file_surat_keluar($id = null)
    {
        if (must_post()) {
            show_404();
            exit;
        }
        if (!isset($_SERVER['HTTP_REFERER']) or !$id) {
            show_404();
            exit;
        }

        $surat = SuratKeluar::find($id);
        if (file_exists('./hasil/surat_keluar/' . $surat->file)) {
            unlink('./hasil/surat_keluar/' . $surat->file);
        }
        $surat->file = '';
        $surat->save();
        $this->session->set_flashdata('notif_file', 'Dokumen file berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function hapus_surat_masuk()
    {
        if (!must_post()) {
            show_404();
            exit;
        }
        try {
            $surat = SuratMasuk::find(request('id'));
            if ((file_exists('./hasil/surat_masuk/' . $surat->file) && $surat->file)) {
                unlink('./hasil/surat_masuk/' . $surat->file);
            }

            foreach ($surat->disposisi as $disposisi) {
                $disposisi->delete();
            }

            $surat->delete();
            echo json_encode([
                'title' => 'Data Berhasil Dihapus',
                'icon' => 'success'
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'title' => 'Terjadi Kesalahan',
                'icon' => 'error',
                'text' => $th->getMessage()
            ]);
        }
    }
    public function hapus_surat_keluar()
    {
        if (!must_post()) {
            show_404();
            exit;
        }
        try {
            $surat = SuratKeluar::find(request('id'));

            $nst =  NomorSuratTerakhir::where("kode", $surat->klasifikasi_surat)->first();

            if ($nst) {
                if ($nst->nomor != $surat->nomor_surat) {
                    throw new Exception("Surat dengan nomor di tengah-tengah tidak bisa di hapus", 1);
                }
            }

            if ((file_exists('./hasil/surat_keluar/' . $surat->file) && $surat->file)) {
                unlink('./hasil/surat_keluar/' . $surat->file);
            }

            $surat->delete();
            echo json_encode([
                'title' => 'Data Berhasil Dihapus',
                'icon' => 'success'
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'title' => 'Terjadi Kesalahan',
                'icon' => 'error',
                'text' => $th->getMessage()
            ]);
        }
    }
    public function disposisi()
    {
        if (!must_post()) {
            show_404();
            exit;
        }
        try {
            Disposisi::create([
                'surat_masuk_id' => request('surat_masuk_id'),
                'pegawai_id' => request('pegawai_id'),
                'nomor_agenda' => request('nomor_index'),
                'isi_disposisi' => request('isi_disposisi')
            ]);
            $this->session->set_flashdata('notif', 'Surat berhasil di disposisi');
            echo 'ok';
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif', $th->getMessage());
        }
        redirect('surat/surat_masuk');
    }
    public function lihat_disposisi($id = null)
    {
        if ($id == null) {
            show_404();
            exit;
        }
        echo json_encode(Disposisi::with('pegawai')->where('surat_masuk_id', $id)->get());
    }
    public function hapus_disposisi($id = null)
    {
        if ($id == null) {
            show_404();
            exit;
        }
        Disposisi::where('id', $id)->delete();
        $this->session->set_flashdata('notif', 'Disposisi Dihapus');
        redirect('surat/surat_masuk');
    }
    public function datatable_disposisi()
    {
        if (!must_post()) {
            show_404();
            exit;
        }

        $this->load->helper('element');
        $this->load->model('DisposisiDatatable');
        $lists = $this->DisposisiDatatable->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($lists as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->asal;
            $row[] = $list->nomor_surat . '<br>Kode: ' . $list->kode_surat;
            $row[] = format_tanggal($list->tanggal_surat);
            $row[] = $list->perihal;
            $row[] = $list->nama;
            $row[] = $list->isi_disposisi;
            $row[] = '<a class="btn btn-success btn-sm"  href="' . base_url('cetak/disposisi/' . $list->id) . '">Cetak</a><a href="' . base_url('surat/hapus_disposisi/' . $list->id) . '" class="btn btn-danger btn-sm">Hapus</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->DisposisiDatatable->count_all(),
            "recordsFiltered" => $this->DisposisiDatatable->count_filtered(),
            "data" => $data,
        );
        header('Content-Type: application/json');
        $this->output->set_output(json_encode($output));
    }
    public function surat_keluar()
    {
        if (isset($_GET['reset'])) {
            $this->session->unset_userdata('awal_periode');
            $this->session->unset_userdata('akhir_periode');
            redirect($_SERVER["HTTP_REFERER"]);
        }

        template('template', 'persuratan/surat_keluar');
    }
    public function save_surat_keluar()
    {

        if (!must_post()) {
            show_404();
            exit;
        }

        $filename = null;

        if ($_FILES['file']['name']) {

            $config['upload_path'] = './hasil/surat_keluar/';
            $config['allowed_types'] = 'jpeg|jpg|png|docx|doc|pdf';
            $config['max_size']  = '8192';
            $config['file_name']  = time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $this->session->set_flashdata('notif_file', $this->upload->display_errors());
            } else {
                $filename = $this->upload->data('file_name');
                $this->session->set_flashdata('notif_file', 'Dokumen file berhasil di upload');
            }
        }

        try {
            SuratKeluar::create([
                'tanggal_surat' => request('tanggal_surat'),
                'tujuan' => request('tujuan'),
                'tanggal_dikirim' => request('tanggal_dikirim'),
                'perihal' => request('perihal'),
                'ringkasan_isi' => request('ringkasan_isi'),
                'catatan' => request('catatan'),
                'file' => $filename
            ]);
            $this->session->set_flashdata('notif', 'Surat keluar berhasil disimpan');
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif', $th->getMessage());
        }

        redirect('surat_keluar/baru');
    }

    public function datatable_surat_keluar()
    {
        if (!must_post()) {
            show_404();
            exit;
        }

        $this->load->helper('element');
        $this->load->model('SuratKeluarDatatable');
        $lists = $this->SuratKeluarDatatable->get_datatables();


        $data = array();
        $no = $this->input->post('start');
        foreach ($lists as $list) {

            // $countSubSurat = $this->db->query("SELECT COUNT(*) as total FROM surat_keluar WHERE nomor_surat LIKE '$list->nomor_surat.%'")->row();

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->tujuan . '<br>Kode: ' . $list->kode_surat . " | Klasifikasi : " . $list->klasifikasi_surat;
            $row[] = checkNomorSurat($list) .  '<br><a target="_blank" href="' . base_url('/surat/sub_nomor/' . $list->nomor_surat) . '" class="btn btn-sm btn-dark">Sub Nomor</a>';
            $row[] = format_tanggal($list->tanggal_surat);
            $row[] = $list->perihal . '<details>' . $list->ringkasan_isi . '</details>';
            $row[] = format_tanggal($list->tanggal_dikirim) . '<br>Catatan : ' . $list->catatan;
            $row[] = checkFileSuratKeluar($list);
            $row[] = '<button onclick="editData(this)" data-json=\'' . json_encode($list, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '\' class="btn btn-warning  btn-sm">Edit</button><button onclick="deleteData(' . $list->id . ')" class="btn btn-danger btn-sm">Hapus</button>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->SuratKeluarDatatable->count_all(),
            "recordsFiltered" => $this->SuratKeluarDatatable->count_filtered(),
            "data" => $data,
        );
        header('Content-Type: application/json');
        $this->output->set_output(json_encode($output));
    }

    public function update_surat_keluar()
    {
        if (!must_post()) {
            show_404();
            exit;
        }
        if (isset($_FILES['file']) && $_FILES['file']['name']) {
            $config['upload_path'] = './hasil/surat_keluar/';
            $config['allowed_types'] = 'jpeg|jpg|png|docx|doc|pdf';
            $config['max_size']  = '8192';
            $config['file_name']  = time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $this->session->set_flashdata('notif_file', $this->upload->display_errors());
                echo json_encode([
                    'title' => 'Terjadi Kesalahan',
                    'icon' => 'error',
                    'text' => $this->upload->display_errors()
                ]);
            } else {
                $surat = SuratKeluar::find(request('id'));
                $surat->file = $this->upload->data('file_name');
                $surat->save();
                $this->session->set_flashdata('notif_file', 'Dokumen file berhasil diupload');
                echo json_encode([
                    'title' => 'Upload file berhail',
                    'icon' => 'success'
                ]);
            }
        } else {

            try {
                SuratKeluar::where('id', request('id'))->update([
                    'tanggal_surat' => request('tanggal_surat'),
                    'tujuan' => request('tujuan'),
                    'kode_surat' => request('kode_surat'),
                    'tanggal_dikirim' => request('tanggal_dikirim'),
                    'perihal' => request('perihal'),
                    'ringkasan_isi' => request('ringkasan_isi'),
                    'catatan' => request('catatan'),
                ]);
                $this->session->set_flashdata('notif', 'Data berhasil diperbarui');
            } catch (\Throwable $th) {
                $this->session->set_flashdata('notif', $th->getMessage());
            }
            if (isset($_GET["from_sub"])) {

                redirect($_SERVER["HTTP_REFERER"]);
            } else {

                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
    }
    public function laporan()
    {
        template('template', 'persuratan/laporan', [
            "kode_surat" => $this->db->query("SELECT DISTINCT LEFT(kode_surat, 2) as kode FROM kode_surat")->result()
        ]);
    }
    public function generate_laporan()
    {
        $bulan = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];
        $dataSurat = null;
        if (isset($_POST['jenis_surat'])) {
            $dataSurat = $this->db->from(request('jenis_surat'));
        }
        if (isset($_POST['bulan']) && isset($_POST['tahun'])) {
            $dataSurat->where('MONTH(tanggal_surat) =', "'" . request('bulan') . "'", false);
            $dataSurat->where('YEAR(tanggal_surat) =', "'" . request('tahun') . "'", false);
        }
        if (isset($_POST['kode_surat']) && request('kode_surat')) {
            $dataSurat->where('kode_surat', $_POST['kode_surat']);
        }
        $data = $dataSurat->get()->result_array();

        if (!$dataSurat || empty($data)) {
            $this->session->set_flashdata('notif', 'Data Tidak DItemukan');
            return redirect('/surat/laporan');
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/template_laporan_surat.docx');
        $templateProcessor->setValue(
            'jenis_surat',
            str_replace('_', ' ', ucfirst(request('jenis_surat')))
        );
        $templateProcessor->setValue('bulan', $bulan[request("bulan")]);
        $templateProcessor->setValue('akhir', request("tahun"));

        // prindie($data);
        $templateProcessor->cloneRow('no', count($data));

        $num = 1;
        for ($i = 0; $i < count($data); $i++) {
            $templateProcessor->setValues(
                [
                    "no#$num" => $num,
                    "asal#$num" => $data[$i]['asal'] ?? 'Pengadilan Agama Jakata Utara',
                    "tujuan#$num" => $data[$i]['tujuan']  ?? 'Pengadilan Agama Jakarta Utara',
                    "n_surat#$num" => $data[$i]['nomor_surat'],
                    "tgl_surat#$num" => $data[$i]['tanggal_surat'],
                    "perihal#$num" => $data[$i]['perihal'],
                    "dikirim#$num" => $data[$i]['tanggal_dikirim'],
                    "diterima#$num" => $data[$i]['tanggal_diterima'] ?? '',
                ]
            );
            $num++;
        }

        $filename = time() . '.docx';
        $templateProcessor->saveAs(FCPATH . 'hasil/' . $filename);

        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename=laporan_surat.docx');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize('./hasil/' . $filename));

        ob_clean();
        flush();

        readfile('./hasil/' . $filename);
        unlink('./hasil/' . $filename);
        exit();
    }

    public function generate($id = null)
    {
        if (!$id) {
            template('template', 'persuratan/generate', [
                'data' => SuratTemplate::all()
            ]);
        } else {
            $this->fetch_template($id);
        }
    }

    public function update_no_register()
    {
        if ($this->input->method() == 'post') {
            try {
                SuratMasuk::find(request('id'))->update(['nomor_register' => request('nomor_register')]);
                $this->session->set_flashdata('notif', 'Nomor Register Berhasil Di Update');
            } catch (\Throwable $th) {
                $this->session->set_flashdata('notif', 'Nomor Register Gagal di Update. Terjadi Kesalahan. Error :' . $th->getMessage());
            }
            redirect('/surat/surat_masuk');
        }
    }
    public function add_from_st()
    {

        if ($this->input->method() == 'post') {
            try {

                $st = SuratTugas::find($this->input->post('id_st'));

                $sk = SuratKeluar::create([
                    "kode_surat" => $this->input->post("kode_surat"),
                    "tanggal_surat" => $st->tanggal_surat,
                    "tujuan" => $st->tujuan,
                    "perihal" =>  $st->perihal,
                    "ringkasan_isi" => $st->tugas,
                    "tanggal_dikirim" => date('Y-m-d'),
                ]);

                SuratKeluarRelation::create([
                    'surat_keluar_id' => $sk->id,
                    'jenis_relation' => 'Surat Tugas',
                    'relation_id' => $st->id
                ]);

                $this->session->set_flashdata('notif', 'Surat Tugas Berhasil di register');
                return redirect('/penomoran');
            } catch (\Throwable $th) {

                $this->session->set_flashdata('notif', 'Terjadi Kesalahan. ' . $th->getMessage());
                return redirect('/penugasan/daftar');
            }
        }
        http_response_code(404);
        exit;
    }

    public function add_from_sd()
    {

        if ($this->input->method() == 'post') {
            try {

                $sd = SuratDinas::find($this->input->post('id_sd'));
                // echo '<pre>';
                // print_r($sd);
                // die;
                $sk = SuratKeluar::create([
                    "kode_surat" => $this->input->post("kode_surat"),
                    "tanggal_surat" => date('Y-m-d'),
                    "tujuan" => $sd->tempat_tujuan,
                    "perihal" => 'Perjalanan Dinas.',
                    "ringkasan_isi" => 'Perjalanan Dinas. ' . $sd->maksud_perjalanan,
                    "tanggal_dikirim" => date('Y-m-d'),
                ]);

                SuratKeluarRelation::create([
                    'surat_keluar_id' => $sk->id,
                    'jenis_relation' => 'Surat Dinas',
                    'relation_id' => $sd->id
                ]);

                $this->session->set_flashdata('notif', 'Surat Tugas Berhasil di register');
                return redirect('/penomoran');
            } catch (\Throwable $th) {

                $this->session->set_flashdata('notif', 'Terjadi Kesalahan. ' . $th->getMessage());
                return redirect('/sppd/daftar');
            }
        }
        http_response_code(404);
        exit;
    }

    public function fetch_template($id)
    {
        template('template', 'persuratan/fetch_template', [
            'data' => SuratTemplate::findOrFail($id)
        ]);
    }

    public function generate_surat_from_template()
    {
        if ($this->input->method() == 'post') {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/uploads/' . request('template_name'));

            fetchKopSurat($templateProcessor);

            $templateProcessor->setValues(request());

            $filename = "GENERATED_" . time() . ".docx";
            $templateProcessor->saveAs(FCPATH . "hasil/" . $filename);
            // redirect($fullpathfilename);
            download_hasil("GENERATED_" . time(), $filename);

            exit;
        }
        http_response_code(404);
        exit;
    }

    public function sub_nomor($nomor = null)
    {
        if ($nomor == null) {
            $this->session->set_flashdata("notif", "Nomor surat belum ditentukan");
            return redirect($_SERVER["HTTP_REFERER"]);
        }

        template('template', 'persuratan/sub_nomor', [
            'nomor' => $nomor,
            'data' => $this->db->query("SELECT * FROM surat_keluar WHERE nomor_surat LIKE '$nomor.%'")->result()
        ]);
    }

    public function autocomplete_asal_surat()
    {
        $querySearch = request('query');
        $data = $this->db->query("SELECT DISTINCT(asal) FROM surat_masuk WHERE asal LIKE '$querySearch%' LIMIT 15")->result_array();

        echo json_encode($data);
    }

    public function autocomplete_tujuan_surat()
    {
        $querySearch = request('query');
        $data = $this->db->query("SELECT DISTINCT(tujuan) FROM surat_keluar WHERE tujuan LIKE '$querySearch%' LIMIT 15")->result_array();

        echo json_encode($data);
    }

    public function autocomplete_nomor_surat()
    {
        $querySearch = request('query');
        $data = $this->db->query("SELECT nomor_surat FROM surat_masuk WHERE nomor_surat LIKE '%$querySearch%' LIMIT 15")->result_array();

        echo json_encode($data);
    }
}
