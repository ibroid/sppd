<?php

use Illuminate\Database\Eloquent\Model;

require_once APPPATH . 'models/MasterPegawai.php';
require_once APPPATH . 'models/Ins_pegawai.php';
class Instrumens extends Model
{
    protected $table = 'instrumen';
    protected $guarded = [];

    public function pegawai()
    {
        return $this->belongsToMany(MasterPegawai::class, 'ins_pegawai', 'instrumen_id', 'pegawai_id');
    }
}
