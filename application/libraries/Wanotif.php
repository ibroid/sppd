<?php

class Wanotif
{
    public $number = "0";
    public $text = "";
    private $ci;

    public function __construct($params)
    {
        $this->number = $params['number'];
        $this->text = $params['text'];
        $this->ci = &get_instance();
    }

    function send()
    {
        try {
            $data = array(
                'chatId' => $this->number,
                'text' => $this->text,
                'session' => 'default'
            );

            $data_string = json_encode($data);
            $username = $_ENV["WA_API_USER"];
            $password = $_ENV["WA_API_PASS"];

            $ch = curl_init($_ENV["WA_API_URL"] . "/api/sendText");

            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            ));

            $result = curl_exec($ch);

            curl_close($ch);

            // prindie($result);
            $this->ci->session->set_flashdata("wa_res_notif", $result);
        } catch (\Throwable $th) {
            //throw $th;
            $this->ci->session->set_flashdata("wa_res_notif", $th->getMessage());
        }
    }
}
