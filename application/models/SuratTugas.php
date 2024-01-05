<?php

require_once APPPATH . 'models/Pegawai.php';
require_once APPPATH . 'models/SuratDinas.php';
class SuratTugas extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'surat_tugas';
    protected $guarded = [];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
    public function surat_dinas()
    {
        return $this->hasOne(SuratDinas::class);
    }
}
