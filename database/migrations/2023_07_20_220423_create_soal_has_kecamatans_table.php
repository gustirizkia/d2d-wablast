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
        Schema::create('soal_has_kecamatans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kecamatan_id');
            $table->bigInteger("soal_id");
            $table->bigInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_has_kecamatans');
    }
};
