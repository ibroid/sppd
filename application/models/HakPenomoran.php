<?php

use Illuminate\Database\Eloquent\Model;

class HakPenomoran extends Model
{
  protected $table = "hak_penomoran";
  protected $guarded = [];

  public function role()
  {
    return $this->belongsTo(Role::class);
  }
}
