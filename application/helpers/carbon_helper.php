<?php

include_once FCPATH . 'vendor/autoload.php';

use Carbon\Carbon;

function carbon()
{
    $c = new Carbon;
    $c->setLocale('id');
    return $c;
}
