<?php

if (!function_exists('vue_template')) {
    function vue_template($component = null)
    {
        $ci = &get_instance();
        if ($component == null) {
            return '<h1>COMPONENT NOT FOUND</h1>';
        }

        return $ci->load->view('mobile/components/' . $component, '', TRUE);
    }
}
