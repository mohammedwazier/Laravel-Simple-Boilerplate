<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipeBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipe_barang', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_nama');
            $table->string('tipe_satuan');
            $table->integer('tipe_jumlah')->description('jumlah dalam bentuk satuan, misal 1 karton berjumlah 24 pcs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipe_barang');
    }
}
