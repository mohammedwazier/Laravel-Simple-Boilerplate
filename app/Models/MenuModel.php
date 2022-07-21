<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    use HasFactory;

    protected $table = "menu";

    public function getChild()
    {
        // From parent Getting Child
        return '';
    }
}
