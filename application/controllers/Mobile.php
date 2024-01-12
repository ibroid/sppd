<?php

use Illuminate\Database\Eloquent\Collection;

defined("BASEPATH") or exit('Kuya batok');

require_once APPPATH . 'models/SuratMasuk.php';
require_once APPPATH . 'models/Jabatan.php';
class Mobile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        try {
            if ($_SERVER["HTTP_CF_IPCOUNTRY"] != "ID") {
                throw new Exception("Your country is not allowed", 1);
            }

            $allowedIP = pengaturan()->mobile_allowed_ip;
            if (str_contains($allowedIP, ";")) {
                $allowedIPs = collect(explode(";", $allowedIP));
                // print_r($allowedIPs);
                if (!$allowedIPs->contains($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                    set_status_header(400);
                    echo "Your ip is not allowed. Please contact web administrator";
                    exit();
                }
            } else {
                if ($_SERVER["HTTP_CF_CONNECTING_IP"] != $allowedIP) {
                    set_status_header(400);
                    echo "Your ip is not allowed. Please contact web administrator";
                    exit();
                }
            }
        } catch (\Throwable $th) {
            set_status_header(400);
            exit($th->getMessage());
        }
    }

    public function index()
    {
        $this->load->helper('vue');
        $data = [];
        if (isset($_GET['time'])) {
            $data['time_limit'] = $this->encryption->decrypt($this->input->get('time'));
        }
        $data['page'] = [
            $this->load->view('mobile/components/home.vue.php', '', TRUE),
            $this->load->view('mobile/components/surat_masuk.vue.php', '', TRUE),
        ];
        // echo '<pre>';
        // print_r($data['page']);
        // die;
        $this->load->view('mobile/index', $data);
    }

    public function redirect()
    {
        if (isset($_GET['id'])) {
            // $page = $this->encryption->decrypt($this->input->get('page'));
            // $id = $this->encryption->decrypt($this->input->get('id'));
            $id = $this->input->get('id');
            // print_r($this->input->get('id'));
            // echo '<br>';
            $page = $this->input->get('page');
            return redirect("mobile#/$page/$id");
        }
        http_response_code(404);
        exit();
    }
}
