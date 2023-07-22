<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('relawans', function (Blueprint $table) {
            $table->id();
            $table->string('username_calon');
            $table->string('nama');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('foto_bersama')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->bigInteger('provinsi_id');
            $table->bigInteger('kota_id');
            $table->bigInteger('kecamatan_id');
            $table->bigInteger('desa_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relawans');
    }
};
