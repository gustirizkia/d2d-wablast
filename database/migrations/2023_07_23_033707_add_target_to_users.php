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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('target')->default(1);
            $table->bigInteger("provinsi_id")->nullable();
            $table->bigInteger("kota_id")->nullable();
            $table->bigInteger("kecamatan_id")->nullable();
            $table->bigInteger("desa_id")->nullable();
            $table->longText("alamat")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
