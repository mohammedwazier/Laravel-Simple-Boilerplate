<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasMenuModel extends Model
{
    use HasFactory;

    protected $table = "menu_has_role";

    public function menuData()
    {
        return $this->hasOne(MenuModel::class, 'id', 'menu_menu_id');
    }
}
