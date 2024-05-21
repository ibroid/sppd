<?php

require_once APPPATH . 'models/Menu.php';
require_once APPPATH . 'models/User.php';
function accessible_menu()
{
    $role = Role::find(auth()->user['role_id']);
    return $role->menu;
}
function count_all_menu(): int
{
    return Menu::count('id');
}
function check_access($idMenu, $access_menu)
{
    $result = [];
    foreach ($access_menu as $k => $v) {
        if ($v->id == $idMenu) {
            array_push($result, $idMenu);
        }
    }
    // return json_encode($result);
    if ($result) {
        return '<span class="badge bg-success">Granted</span>';
    }
    return '<span class="badge bg-danger">Ungranted</span>';
}
