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
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->id('kode');
            $table->string('kode_mk');
            $table->string('nama');
            $table->integer('sks');
            $table->integer('semester');
            $table->enum('aktif', ['True', 'False']);
            $table->enum('jenis', ['TEORI', 'PRAKTIKUM']);
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
        Schema::dropIfExists('matkul');
    }
};
