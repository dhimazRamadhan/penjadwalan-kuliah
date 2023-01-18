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
        Schema::create('pengampu', function (Blueprint $table) {
            $table->id('kode');
            $table->integer('kode_mk');
            $table->integer('kode_dosen');
            $table->string('kelas');
            $table->string('tahun_akademik');

            // $table->foreign('id_mk')
            //       ->references('matkul')
            //       ->on('id');

            // $table->foreign('id_dosen')
            //       ->references('dosen')
            //       ->on('id');

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
        Schema::dropIfExists('pengampu');
    }
};
