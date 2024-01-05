<?php
include_once APPPATH . 'models/SuratTugas.php';
include_once APPPATH . 'models/Disposisi.php';
class Cetak extends CI_Controller
{
    public function sppd($surat_id, $pegawai_id)
    {
        $data =  SuratTugas::with(['pegawai' => function ($query) use ($pegawai_id) {
            return $query->where('id', $pegawai_id);
        }])->where('id', $surat_id)->first();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/template_surat_dinas.docx');

        echo "<pre>";
        print_r($templateProcessor->getVariableCount());
        // die;
        $templateProcessor->setValues([
            'tanggal_berangkat' => format_tanggal($data->surat_dinas->tanggal_berangkat),
            'tujuan' => $data->surat_dinas->tempat_tujuan,
            'tanggal_tiba' => format_tanggal($data->surat_dinas->tanggal_tiba),
            'tanggal_pulang' => format_tanggal($data->surat_dinas->tanggal_pulang),
            'nama_ppk' => pengaturan()->nama_ppk,
            'nip_ppk' => pengaturan()->nip_ppk,
        ]);
        $pengaturan = pengaturan();
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
        $filename = time() . '.docx';
        $templateProcessor->saveAs(FCPATH . 'hasil/' . $filename);

        download_hasil('SPPD_' . str_replace(',', '', str_replace(' ', '_', $data->pegawai[0]->nama))   . '.docx', $filename);
    }
    public function spd($surat_id, $pegawai_id)
    {
        $data =  SuratTugas::with(['pegawai' => function ($query) use ($pegawai_id) {
            return $query->where('id', $pegawai_id);
        }])->where('id', $surat_id)->first();


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/template_spd.docx');
        // echo '<pre>';
        // print_r($data->pegawai->toArray());
        // die;
        $templateProcessor->setValues([
            'nama_satker' => pengaturan()->nama_satker,
            'nomor_surat' => $data->surat_dinas->nomor_surat,
            'pegawai' => $data->pegawai[0]->nama,
            'nip' => $data->pegawai[0]->nip,
            'pangkat' => $data->pegawai[0]->pangkat . '(' . $data->pegawai[0]->golongan . ')',
            'jabatan' => $data->pegawai[0]->jabatan,
            'maksud' => $data->surat_dinas->maksud_perjalanan,
            'angkutan' => $data->surat_dinas->transportasi,
            'tujuan' => $data->surat_dinas->tempat_tujuan,
            'lama_hari' => date_diff(date_create($data->surat_dinas->tanggal_berangkat), date_create($data->surat_dinas->tanggal_pulang)),
            'tanggal_berangkat' => format_tanggal($data->surat_dinas->tanggal_berangkat),
            'tanggal_kembali' => format_tanggal($data->surat_dinas->tanggal_pulang),
            'tanggal_sekarang' => format_tanggal(date('Y-m-d')),
            'nama_ppk' => pengaturan()->nama_ppk,
            'nip_ppk' => pengaturan()->nip_ppk
        ]);

        $named = 'SPD_' . str_replace(',', '', str_replace(' ', '_', $data->pegawai[0]->nama))   . '.docx';
        $filename = time() . '.docx';
        $templateProcessor->saveAs(FCPATH . 'hasil/' . $filename);

        download_hasil($named, $filename);
    }
    public function rincian_kwitansi($surat_id, $pegawai_id)
    {
        $data =  SuratTugas::with(['pegawai' => function ($query) use ($pegawai_id) {
            return $query->where('id', $pegawai_id);
        }])->where('id', $surat_id)->first();


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/template_rincian_kwitansi.docx');
        $templateProcessor->setValues([
            'nomor_surat' => $data->surat_dinas->nomor_surat,
            'tanggal_surat' => carbon()->parse($data->tanggal_surat)->isoFormat('D MMMM Y'),
        ]);
        $countBiayaItem = $data->surat_dinas->biaya->count('*');
        $templateProcessor->cloneRow('no', $countBiayaItem);
        $num = 1;
        $pembiayaan =  $data->surat_dinas->biaya->toArray();
        for ($i = 0; $i < $countBiayaItem; $i++) {
            $total_biaya = floatval($pembiayaan[$i]['biaya']) * floatval($pembiayaan[$i]['jumlah']);
            $templateProcessor->setValues(
                [
                    "no#$num" => $num,
                    "keperluan#$num" => $pembiayaan[$i]['keperluan'],
                    "biaya#$num" => rupiah($pembiayaan[$i]['biaya']),
                    "jumlah#$num" => $pembiayaan[$i]['jumlah'],
                    "keterangan#$num" => $pembiayaan[$i]['keterangan'],
                    "total_biaya#$num" => rupiah($total_biaya),
                ]
            );
            $num++;
        }
        $totalPengeluaran = 0;
        foreach ($data->surat_dinas->biaya as $val) {
            $totalPengeluaran += floatval($val->biaya)  * floatval($val->jumlah);
        }
        $templateProcessor->setValues([
            "total_semua" => rupiah($totalPengeluaran),
            "total_terbilang" => terbilang($totalPengeluaran),
            "tanggal_pencairan" => format_tanggal($data->surat_dinas->tanggal_pencairan),
            'nama_ppk' => pengaturan()->nama_ppk,
            'nip_ppk' => pengaturan()->nip_ppk,
            "nama_pegawai" => $data->pegawai[0]->nama,
            "nip_pegawai" => $data->pegawai[0]->nip,
        ]);
        $filename = 'RINCIAN_KWITANSI_' . str_replace(',', '', str_replace(' ', '_', $data->pegawai[0]->nama))   . '.docx';
        $templateProcessor->saveAs(FCPATH . 'hasil/' . $filename);
        redirect('hasil/' . $filename);
    }

    public function kwitansi($surat_id, $pegawai_id)
    {
        $data =  SuratTugas::with(['pegawai' => function ($query) use ($pegawai_id) {
            return $query->where('id', $pegawai_id);
        }])->where('id', $surat_id)->first();


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/template_kwitansi.docx');
        echo '<pre>';
        print_r($templateProcessor->getVariableCount());
        $templateProcessor->setValues([
            "total_semua" => rupiah($data->surat_dinas->biaya->sum('biaya')),
            "total_terbilang" => terbilang($data->surat_dinas->biaya->sum('biaya')),
            "tanggal_pencairan" => format_tanggal($data->surat_dinas->tanggal_pencairan),
            "nama_bendahara" => pengaturan()->nama_bendahara,
            "nip_bendahara" => pengaturan()->nip_bendahara,
            "nama_pegawai" => $data->pegawai[0]->nama,
            "nip_pegawai" => $data->pegawai[0]->nip,
            "maksud" => $data->surat_dinas->maksud_perjalanan,
            "tujuan" => $data->surat_dinas->tempat_tujuan,
            "nomor_surat" => $data->surat_dinas->nomor_surat,
            "tanggal_surat" => format_tanggal($data->tanggal_surat),
            "nama_ppk" => pengaturan()->nama_ppk,
            "nip_ppk" => pengaturan()->nip_ppk
        ]);
        $filename = 'KWITANSI_' . str_replace(',', '', str_replace(' ', '_', $data->pegawai[0]->nama))   . '.docx';
        $templateProcessor->saveAs(FCPATH . 'hasil/' . $filename);
        redirect('hasil/' . $filename);
    }
    public function riil($surat_id, $pegawai_id)
    {
        $data =  SuratTugas::with(['pegawai' => function ($query) use ($pegawai_id) {
            return $query->where('id', $pegawai_id);
        }])->where('id', $surat_id)->first();


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/template_pengeluaran_riil.docx');
        echo '<pre>';
        print_r($templateProcessor->getVariableCount());
        $templateProcessor->setValues([
            "nama_pegawai" => $data->pegawai[0]->nama,
            "nip_pegawai" => $data->pegawai[0]->nip,
            "jabatan_pegawai" => $data->pegawai[0]->jabatan,
            "nomor_surat" => $data->surat_dinas->nomor_surat,
            "total" => rupiah($data->surat_dinas->riil->sum('harga')),
            "tanggal_pencairan" => format_tanggal($data->surat_dinas->tanggal_pencairan),
            "nama_ppk" => pengaturan()->nama_ppk,
            "nip_ppk" => pengaturan()->nip_ppk
        ]);
        $countBiayaItem = $data->surat_dinas->riil->count('*');
        $templateProcessor->cloneRow('no', $countBiayaItem);
        $pembiayaan =  $data->surat_dinas->riil->toArray();
        $num = 1;
        for ($i = 0; $i < $countBiayaItem; $i++) {
            $templateProcessor->setValues(
                [
                    "no#$num" => $num,
                    "keperluan#$num" => $pembiayaan[$i]['keperluan'],
                    "biaya#$num" => rupiah($pembiayaan[$i]['harga']),
                    "jumlah#$num" => $pembiayaan[$i]['jumlah'],
                    "keterangan#$num" => $pembiayaan[$i]['keterangan'],
                ]
            );
            $num++;
        }
        $filename = 'PENGELUARAN_RIIL_' . str_replace(',', '', str_replace(' ', '_', $data->pegawai[0]->nama))   . '.docx';
        $templateProcessor->saveAs(FCPATH . 'hasil/' . $filename);
        redirect('hasil/' . $filename);
    }
    public function surat_tugas_template()
    {
        Pengaturan::where('name', 'template_surat_tugas')->update([
            'value' => request('template')
        ]);
        echo json_encode(['status' => 200]);
    }
    public function disposisi($id = null)
    {
        if ($id == null) {
            show_404();
            exit;
        }

        $data = Disposisi::find($id);

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/template_disposisi.docx');
        // echo '<pre>';
        // print_r($templateProcessor->getVariableCount());
        // die;
        $templateProcessor->setImageValue('logo', [
            'path' => './logo/' . pengaturan()->logo_satker,
            'width' => 50, 'height' => 50, 'ratio' => false
        ]);
        $templateProcessor->setValues([
            'kode_surat' => $data->surat_masuk->kode_surat,
            'tanggal_surat' => format_tanggal($data->surat_masuk->tanggal_surat),
            'nomor_surat' => $data->surat_masuk->nomor_surat,
            'asal_surat' => $data->surat_masuk->asal,
            'isi_ringkas' => $data->surat_masuk->ringkasan_isi,
            'tanggal_diterima' => format_tanggal($data->surat_masuk->tanggal_diterima),
            'no_ag' => $data->nomor_agenda,
            'nama_pegawai' => $data->pegawai->nama,
            'isi_disposisi' => $data->isi_disposisi,
            'nama_ketua' => pengaturan()->nama_ketua,
            'nip_ketua' => pengaturan()->nip_ketua,
        ]);

        $filename = time() . '.docx';
        $templateProcessor->saveAs(FCPATH . 'hasil/' . $filename);

        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename=disposisi_surat' . $data->surat_masuk->asal . '.docx');
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
}
