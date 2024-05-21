<?php

require_once APPPATH . 'models/SuratTugas.php';
require_once APPPATH . 'models/Biaya.php';
require_once APPPATH . 'models/PengeluaranRiil.php';
class SuratDinas extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'surat_dinas';
    protected $guarded = [];

    public function surat_tugas()
    {
        return $this->belongsTo(SuratTugas::class);
    }

    public function biaya()
    {
        return $this->hasMany(Biaya::class);
    }
    public function riil()
    {
        return $this->hasMany(PengeluaranRiil::class);
    }
}
