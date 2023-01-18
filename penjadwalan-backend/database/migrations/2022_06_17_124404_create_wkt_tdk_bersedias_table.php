<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waktu_tidak_bersedia', function (Blueprint $table) {
            $table->id('kode');
            $table->integer('kode_dosen');
            $table->integer('kode_hari');
            $table->integer('kode_jam');
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
        Schema::dropIfExists('wkt_tdk_tersedia');
    }
};
