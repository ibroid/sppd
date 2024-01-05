<?php

require_once APPPATH . "models/Menu.php";
require_once APPPATH . "models/AccessMenu.php";
require_once APPPATH . "models/HakPenomoran.php";

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    public function menu()
    {
        return $this->hasManyThrough(Menu::class, AccessMenu::class, 'role_id', 'id', 'id', 'menu_id')->orderBy('menu_id');
    }
    public function accessible_menu()
    {
        return $this->hasMany(AccessMenu::class);
    }

    public function hak_penomoran()
    {
        return $this->hasMany(HakPenomoran::class);
    }
}
