<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            // $table->string('menu_id')->unique();
            $table->string('menu_url');
            $table->string('menu_title');
            $table->string('menu_icon')->nullable();
            $table->enum('menu_type', ['link', 'header', 'sub_link']);
            $table->integer('menu_parent')->default(0);
            $table->integer('menu_sort')->default(0);
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
        Schema::dropIfExists('menu');
    }
}
