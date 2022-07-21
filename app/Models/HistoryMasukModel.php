<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryMasukModel extends Model
{
    use HasFactory;

    protected $table = "history_masuk";

    public function gambar()
    {
        return $this->hasMany(HistoryGambarModel::class, 'id_history', 'id')->where('type_history', 'masuk');
    }

    public function barang()
    {
        return $this->hasOne(BarangModel::class, 'id', 'id_barang');
    }

    public function tipeBarang()
    {
        return $this->hasOne(TipeBarangModel::class, 'id', 'id_tipe_barang');
    }

    public function userInput()
    {
        return $this->hasOne(User::class, 'id', 'user_input');
    }
}
