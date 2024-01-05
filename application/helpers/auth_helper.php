<?php

function auth()
{
    return new class
    {
        private $ins;
        public function __construct()
        {
            $this->ins = get_instance();
            $this->pegawai = $this->ins->session->userdata('spd_pegawai');
            $this->user = $this->ins->session->userdata('spd_user');
        }
        public function check()
        {
            return $this->ins->session->userdata('spd_is_loggin');
        }
    };
}
