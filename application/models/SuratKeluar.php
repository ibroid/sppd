<?php

require_once APPPATH . 'models/SuratKeluarRelation.php';
require_once APPPATH . 'models/SuratTerhapus.php';

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            SuratKeluarRelation::where('surat_keluar_id', $model->id)->delete();

            NomorSuratTerakhir::where("kode", $model->klasifikasi_surat)->update(["nomor" => $model->nomor_surat - 1]);
        });

        // self::updating();

        self::deleting(function ($model) {
            SuratTerhapus::create([
                'tujuan' => $model->tujuan,
                'perihal' => $model->perihal,
                'nomor_surat' => $model->nomor_surat,
                'ringkasan_isi' => $model->ringkasan_isi,
                'tanggal_dikirim' => $model->tanggal_dikirim,
                'tanggal_surat' => $model->tanggal_surat,
                'deleted_by' => auth()->user['id']
            ]);
        });
    }

    public function surat_keluar_relation()
    {
        return $this->hasOne(SuratKeluarRelation::class);
    }
}
