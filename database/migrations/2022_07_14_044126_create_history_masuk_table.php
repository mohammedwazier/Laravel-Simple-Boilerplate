<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_masuk', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barang');
            $table->integer('id_tipe_barang');
            $table->integer('history_jumlah_masuk');
            $table->integer('history_jumlah_masuk_pcs');
            $table->integer('user_input');
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
        Schema::dropIfExists('history_masuk');
    }
}
