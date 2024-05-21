<?php

use Illuminate\Database\Eloquent\Model;


class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $guarded = [];

    public function atasan()
    {
        return $this->belongsTo($this, 'atasan_langsung', 'id');
    }
    public function pejabat()
    {
        return $this->belongsTo($this, 'atasan_pemberi_izin', 'id');
    }
}
