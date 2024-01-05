<?php

use Illuminate\Database\Eloquent\Model;

class NomorSuratTerakhir extends Model
{
  protected $table = "nomor_surat_terakhir";
  protected $guarded = ["id", "kode"];
}
