<?php

class Wanotif
{
    private $base_url = "";
    private $session = "default";
    private $end_point = "/api/sendText";
    public $number = "0";
    public $text = "";
    private $ci;

    public function __construct($params)
    {
        $this->number = $params['number'];
        $this->text = $params['text'];
        $this->ci = get_instance();
    }

    function send()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->base_url . $this->end_point);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                "{
						\"chatId\" : \"$this->number\",
						\"text\" : \"$this->text\",
						\"session\" : \"$this->session\"
					}"
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $th) {
            $this->ci->session->set_flashdata($th->getMessage(), 'wa_res_notif');
        }
    }
}
