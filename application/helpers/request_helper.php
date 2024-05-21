<?php

class Request
{
    function __construct($req)
    {
        foreach ($req as $key => $value) {
            $this->$key = $value[$key];
        }
    }
}

function request($key = null)
{
    $these = &get_instance();
    if ($key == null) {
        return $these->input->post();
    }
    return $these->input->post($key, TRUE);
}

function nomor_surat($par)
{
    return str_replace('{nomor}', $par, pengaturan()->nomor_surat);
}

function must_post()
{
    $these = &get_instance();
    return ($these->input->method() == 'post');
}
