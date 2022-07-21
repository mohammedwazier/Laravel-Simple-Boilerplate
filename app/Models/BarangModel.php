<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = "master_barang";

    public function gambarBarang()
    {
        return $this->hasMany(MasterGambarBarangModel::class, 'id_barang', 'id');
    }
}
