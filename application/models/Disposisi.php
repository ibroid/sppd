<?php

require_once APPPATH . "models/MasterPegawai.php";
require_once APPPATH . "models/SuratMasuk.php";
require_once APPPATH . 'libraries/Wanotif.php';

use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $table = 'disposisi';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $ci = &get_instance();

            $pegawai = MasterPegawai::find($model->pegawai_id);

            $encId = $ci->encryption->encrypt($model->surat_masuk_id);
            $encPage = $ci->encryption->encrypt('surat_masuk');

            // $url = urlencode()
            $wanotif = new Wanotif([
                'number' => $pegawai->nomor_telepon,
                'text' => "*Notifikasi Disposisi Surat.* Anda mendapat disposisi Surat. Lihat selengkapnya dengan menekan link ini: " . base_url('/mobile/redirect?page=surat_masuk&id=' . $model->surat_masuk_id),
            ]);

            $wanotif->send();
        });
    }

    public function pegawai()
    {
        return $this->belongsTo(MasterPegawai::class);
    }

    public function surat_masuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }
}
