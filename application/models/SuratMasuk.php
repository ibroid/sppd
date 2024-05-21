<?php

require_once APPPATH . 'models/Disposisi.php';
require_once APPPATH . 'models/MasterPegawai.php';
require_once APPPATH . 'models/SuratTerhapus.php';
require_once APPPATH . 'libraries/Wanotif.php';

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';
    protected $guarded = [];

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $ci = &get_instance();

            $sekretaris = MasterPegawai::where(['jabatan_id' => 5, 'aktif' => 1])->first();

            if (empty($sekretaris->nomor_telepon)) {
                return;
            }

            $encTime = $ci->encryption->encrypt(strtotime('+2 hours'));
            $encId = $ci->encryption->encrypt($model->id);
            $encPage = $ci->encryption->encrypt('surat_masuk');
            $wanotif = new Wanotif([
                'number' => $sekretaris->nomor_telepon,
                'text' => "*Notifikasi Surat Masuk.* Surat masuk dari $model->asal. Nomor surat $model->nomor_surat. Perihal $model->perihal. Silahkan buat disposisi anda dengan menekan link ini: " . base_url('/mobile/redirect?page=surat_masuk&id=' . $model->id),
            ]);

            $wanotif->send();
        });

        self::creating(function ($model) {
            $nrt = pengaturan()->nrt_surat_masuk;

            $nnt  = floatval($nrt) + 1;

            pengaturan()->update('nrt_surat_masuk', $nnt);

            $model->nomor_register = $nnt;
            return $model;
        });

        self::deleting(function ($model) {
            SuratTerhapus::create([
                'asal' => $model->asal . "(No Reg : $model->nomor_register)",
                'perihal' => $model->perihal,
                'nomor_surat' => $model->nomor_surat,
                'ringkasan_isi' => $model->ringkasan_isi,
                'tanggal_diterima' => $model->tanggal_diterima,
                'tanggal_surat' => $model->tanggal_surat,
                'deleted_by' => auth()->user['id']
            ]);
        });
    }
}
