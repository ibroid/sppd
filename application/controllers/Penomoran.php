<?php

require_once APPPATH . 'models/SuratTugas.php';
require_once APPPATH . 'models/SuratKeluar.php';
require_once APPPATH . 'models/SuratDinas.php';
require_once APPPATH . 'models/SuratKeluarRelation.php';
require_once APPPATH . 'models/KodeSurat.php';
require_once APPPATH . 'models/Role.php';
require_once APPPATH . 'models/NomorSuratTerakhir.php';
require_once APPPATH . 'models/HakPenomoran.php';

class Penomoran extends CI_Controller
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
        template('template', 'persuratan/penomoran');
    }
    public function update($id)
    {
        if ($this->input->method() != 'post') {
            http_response_code(404);
            exit();
        }

        try {
            $st = SuratTugas::findOrFail($id);
            $st->nomor_surat = request('nomor_surat');
            $st->tanggal_surat = request('tanggal_surat');
            $st->save();
            $this->session->set_flashdata('notif', 'Penomoran Surat Berhasil di Update');
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notif', 'Terjadi Kesalahan :' . $th->getMessage());
            // throw $th;
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    public function format()
    {
        if (isset($_POST['nomor_surat'])) {
            # code...
            if (strpos(request('nomor_surat'), '{nomor}') !== false) {
                Pengaturan::where('name', array_keys($_POST)[0])->update([
                    'value' => request('nomor_surat')
                ]);
                $this->session->set_flashdata('notif', 'Update Format Berhasil');
            } else {
                $this->session->set_flashdata('notif', 'Harus mencantumkan kata {nomor} di dalam format');
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            show_404();
        }
    }
    public function datatable()
    {
        if (!must_post()) {
            show_404();
            exit;
        }

        $this->load->model('PenomoranDatatable');
        $lists = $this->PenomoranDatatable->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($lists as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->tujuan . '<br>Tanggal Surat : ' . format_tanggal($list->tanggal_surat);
            $row[] = $this->load->view("component/select_klasifikasi_surat", [
                "kode" => Role::find($this->session->userdata("spd_user")["role_id"])->hak_penomoran,
                "id" => $list->id
            ], TRUE);
            $row[] = inputKodeSurat($list->id, $list->kode_surat);
            $row[] = $this->load->view("component/input_nomor_surat", ["id" => $list->id], TRUE);
            $row[] = $list->perihal . '<details>' . $list->ringkasan_isi . '</details>';
            $row[] = '<button onclick="saveNomorSurat(' . $list->id . ')" id="button-submit-' . $list->id . '" class="btn btn-success btn-sm">Simpan</button>';
            $row[] = '<div class="alert alert-light-primary color-primary" id="log-' . $list->id . '"><strong>Log Here</strong></div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->PenomoranDatatable->count_all(),
            "recordsFiltered" => $this->PenomoranDatatable->count_filtered(),
            "data" => $data,
        );
        header('Content-Type: application/json');
        $this->output->set_output(json_encode($output));
    }

    public function save_surat_keluar()
    {
        if (!must_post()) {
            show_404();
            exit;
        }

        try {
            // $cekMundur = explode('.', request('nomor_surat'));
            // print_r(count($cekMundur));
            // die;

            $cek = SuratKeluar::where([
                'nomor_surat' => request('nomor_surat'),
                'klasifikasi_surat' => request('klasifikasi_surat'),
            ])->whereYear('tanggal_surat', date("Y"))->first();
            if ($cek) {
                throw new Exception("Nomor Surat sudah dipakai", 1);
            }
            $surat = SuratKeluar::find(request('id'));
            $surat->nomor_surat = request('nomor_surat');
            $surat->kode_surat = request('kode_surat');
            $surat->klasifikasi_surat = request('klasifikasi_surat');
            $surat->save();

            if ($surat->surat_keluar_relation) {
                if ($surat->surat_keluar_relation->jenis_relation == 'Surat Tugas') {
                    SuratTugas::where('id', $surat->surat_keluar_relation->relation_id)
                        ->update([
                            'nomor_surat' => formatNomorSurat($surat->nomor_surat, $surat->kode_surat)
                        ]);
                }

                if ($surat->surat_keluar_relation->jenis_relation == 'Surat Dinas') {
                    SuratDinas::where('id', $surat->surat_keluar_relation->relation_id)
                        ->update([
                            'nomor_surat' => formatNomorSurat($surat->nomor_surat, $surat->kode_surat)
                        ]);
                }
            }

            $this->session->set_flashdata('notif', 'Nomor Surat Berhasil Disimpan');

            NomorSuratTerakhir::where("kode", request("klasifikasi_surat"))->update([
                "nomor" => request("nomor_surat")
            ]);
            // pengaturan()->update('nrt_surat_keluar', request('nomor_surat'));

            echo json_encode([
                'title' => 'Sukses',
                'text' => 'Nomor Surat Berhasil Disimpan',
                'icon' => 'success'
            ]);
            exit;
        } catch (\Throwable $th) {
            // throw $th;
            // exit;
            $this->session->set_flashdata('notif', $th->getMessage());
            echo json_encode([
                'title' => 'Terjadi kesalahan',
                'text' => $th->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
    public function daftar()
    {
        template('template', 'persuratan/daftar_kode', [
            'data' => KodeSurat::all()
        ]);
    }
    public function save_kode($id = null)
    {
        if ($this->input->method() == 'post') {
            try {
                if ($id) {
                    KodeSurat::where("id", $id)->update([
                        'kode_surat' => request('kode_surat'),
                        'keterangan' => request('keterangan')
                    ]);
                } else {
                    KodeSurat::insert([
                        'kode_surat' => request('kode_surat'),
                        'keterangan' => request('keterangan')
                    ]);
                }
                $this->session->set_flashdata('notif', 'Berhasil Ditambahkan');
            } catch (\Throwable $th) {
                $this->session->set_flashdata('notif', 'Terjadi Kesalahan. ' . $th->getMessage());
            }

            return redirect('/penomoran/daftar');
        }
        http_response_code(404);
        exit;
    }

    public function hapus_kode()
    {
        if ($this->input->method() == 'post') {
            try {
                $json = file_get_contents('php://input');
                $data = json_decode($json, true);
                // print_r($data);
                // die;
                KodeSurat::where('id', $data['id'])->delete();
                echo json_encode([
                    'status' => 'Berhasil',
                    'message' => 'Kode berhasil dihapus'
                ]);
                exit();
            } catch (\Throwable $th) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'Berhasil',
                    'message' => 'Kode berhasil dihapus'
                ]);
                exit();
            }
        }
        http_response_code(404);
        exit;
    }

    public function hapus_nomor_surat()
    {
        if ($this->input->method() == 'post') {

            try {
                $st = SuratKeluar::find(request('id'));

                if (!$st) {
                    throw new Exception("Data tidak ditemukan", 1);
                }

                if (isset($st->surat_keluar_relation) && $st->surat_keluar_relation) {

                    if ($st->surat_keluar_relation->jenis_relation == 'Surat Tugas') {
                        SuratTugas::where('id', $st->surat_keluar_relation->relation_id)->update([
                            'nomor_surat' => ''
                        ]);
                    }

                    if ($st->surat_keluar_relation->jenis_relation == 'Surat Dinas') {
                        SuratDinas::where('id', $st->surat_keluar_relation->relation_id)->update([
                            'nomor_surat' => ''
                        ]);
                    }
                }


                if (pengaturan()->nrt_surat_keluar == $st->nomor_surat) {
                    pengaturan()->update('nrt_surat_keluar', $st->nomor_surat - 1);
                }

                $st->update([
                    'nomor_surat' => ''
                ]);

                echo json_encode([
                    'status' => 'Berhasil',
                    'message' => 'Nomor surat berhasil dihapus'
                ]);

                $this->session->set_flashdata('notif', 'Nomor surat berhasil dihapus');
            } catch (\Throwable $th) {
                echo json_encode([
                    'status' => 'Terjadi Kesalahan',
                    'message' => $th->getMessage()
                ]);
                $this->session->set_flashdata('notif', 'Terjadi kesalahan. ' . $th->getMessage());
            }


            exit;
        }
        http_response_code(404);
        exit;
    }

    public function hak_akses()
    {
        template('template', 'setting_hak_penomoran', [
            "roles" => Role::all(),
            "jenis_nomor" => NomorSuratTerakhir::select("kode")->get()
        ]);
    }

    public function tambah_hak()
    {
        try {
            HakPenomoran::where("role_id", request("role_id"))->delete();

            foreach (request("kode") as $kode) {
                HakPenomoran::create([
                    "role_id" => request("role_id"),
                    "kode" => $kode
                ]);
            }
            $this->session->set_flashdata("notif", "Pemberian Hak Penomoran Berhasil");
        } catch (\Throwable $th) {
            $this->session->set_flashdata("notif", $th->getMessage());
        }

        redirect('penomoran/hak_akses');
    }

    public function fetch_form()
    {
        $role = Role::find(request("role_id"));
        // prindie($role);
        $this->load->view("component/form_ubah_hak", ["role" => $role, "jenis_nomor" => NomorSuratTerakhir::select("kode")->get()]);
    }

    public function nomor_surat_terakhir($kode)
    {
        $nst = NomorSuratTerakhir::where("kode", $kode)->first();
        echo $nst->nomor + 1;
    }

    public function nomor_terakhir()
    {
        template('template', 'nomor_terakhir', [
            "roles" => Role::all(),
            "jenis_nomor" => NomorSuratTerakhir::all()
        ]);
    }

    public function update_nomor_terakhir($id = null)
    {
        if ($id == null) {
            return show_404("Teu aya bos");
        }

        $nst = NomorSuratTerakhir::find($id);
        $nst->update($this->input->post());

        $this->session->set_flashdata("notif", "Nomor surat terakhir sudah diperbaharui");
        redirect("penomoran/nomor_terakhir");
    }
}
