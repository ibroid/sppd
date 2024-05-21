<?php

require_once APPPATH . "models/Jabatan.php";
require_once APPPATH . "models/SuratDinas.php";

class Debug extends CI_Controller
{
    public function index()
    {
        show_404();
    }
}
