<?php
defined('BASEPATH') or exit('No direct script access allowed');


class SuratKeluarDatatable extends CI_Model
{
    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'surat_keluar';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array('nomor_surat', 'tujuan', 'tanggal_surat', 'kode_surat', 'tanggal_dikirim', 'perihal', 'ringkasan_isi');

    var $column_search = array('nomor_surat', 'tujuan', 'tanggal_surat', 'kode_surat', 'tanggal_dikirim', 'perihal', 'ringkasan_isi');
    // default order 
    var $order = array('CAST(nomor_surat AS SIGNED)' => 'desc');

    public $klasifikasi = null;

    public function __construct()
    {
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        if ($this->session->userdata('awal_periode') && $this->session->userdata('akhir_periode')) {
            $this->db->where('tanggal_dikirim >=', $this->session->userdata('awal_periode'));
            $this->db->where('tanggal_dikirim <=', $this->session->userdata('akhir_periode'));
        } else {
            $this->db->where('MONTH(tanggal_surat)', date("m"), TRUE);
            $this->db->where('YEAR(tanggal_surat)', date("Y"), TRUE);
        }
        if ($this->klasifikasi == null) {
            $this->db->where('nomor_surat IS NULL', null, FALSE);
        } else {
            $this->db->where('nomor_surat NOT LIKE', '%.%', TRUE);
            $this->db->where('klasifikasi_surat', $this->klasifikasi, TRUE);
        }

        // $this->db->order_by('CAST(nomor_surat AS SIGNED)', "DESC");
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
