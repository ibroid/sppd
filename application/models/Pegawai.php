<?php

include_once APPPATH . 'models/Jabatan.php';
class Pegawai  extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'pegawai';
    protected $guarded = [];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
