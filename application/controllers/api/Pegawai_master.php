<?php
defined("BASEPATH") or exit("Kuya batok");
include_once APPPATH . 'models/MasterPegawai.php';
class Pegawai_master extends CI_Controller
{

      public function __construct()
      {
            parent::__construct();
            if (count($_GET) > 0) {
                  set_status_header(404);
                  exit("Please do not try anything");
            }
            if (count($_FILES) > 0) {
                  set_status_header(404);
                  exit("Please do not try anything");
            }
            if (count($_POST) > 0) {
                  set_status_header(404);
                  exit("Please do not try anything");
            }
      }

      public function list()
      {
            echo json_encode(MasterPegawai::where('aktif', 1)->orderBy('jabatan_id')->get()->toArray());
      }
}
