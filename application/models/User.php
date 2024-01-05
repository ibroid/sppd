<?php

require_once APPPATH . "models/MasterPegawai.php";
require_once APPPATH . "models/Role.php";

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = [];

    public function pegawai()
    {
        return $this->belongsTo(MasterPegawai::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
