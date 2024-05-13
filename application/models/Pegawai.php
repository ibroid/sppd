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

    public function autocomplete_pegawai()
    {
        $querySearch = request('query');
        $data = $this->db->query("SELECT nama FROM master_pegawai WHERE nama LIKE '%$querySearch%' LIMIT 15")->result_array();

        echo json_encode($data);
    }
}
