<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_barang', function (Blueprint $table) {
            // Semua barang ini dalam bentuk satuan PCS, nanti jika masuk ke dalam database Barang akan dikonversikan terlebih dahulu ke satuan PCS
            $table->id();
            $table->string('barang_nama');
            $table->integer('barang_total')->description('barang ini bakal terus bertambah');
            $table->integer('barang_keluar')->description('pada barang keluar akan terus bertambah');
            $table->integer('barang_reject')->description('pada barang reject akan terus bertambah nilainya');
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
        Schema::dropIfExists('master_barang');
    }
}
