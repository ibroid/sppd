<?php

require_once APPPATH . "models/Jabatan.php";
require_once APPPATH . "models/Golongan.php";

use Illuminate\Database\Eloquent\Model;

class MasterPegawai extends Model
{
    protected $table = 'master_pegawai';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $jabatan = Jabatan::find($model->jabatan_id);

            if ($jabatan->single == 1) {
                self::where('id', '!=', $model->id)->where('jabatan_id', $model->jabatan_id)->update([
                    'aktif' => 0
                ]);
            }
        });

        self::updating(function ($model) {
            $jabatan = Jabatan::find($model->jabatan_id);

            if ($jabatan->single == 1) {
                self::where('id', '!=', $model->id)->where('jabatan_id', $model->jabatan_id)->update([
                    'aktif' => 0
                ]);
            }
        });
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
