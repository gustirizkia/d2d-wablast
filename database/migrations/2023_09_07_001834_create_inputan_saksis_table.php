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
        Schema::create('inputan_saksis', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('user_id');
            $table->string('rw');
            $table->string('rt');
            $table->string('tps');
            $table->bigInteger('total_dpt');
            $table->bigInteger('suara_sah');
            $table->bigInteger('suara_tidak_sah')->default(0);
            $table->bigInteger('golput')->default(0);
            $table->string('foto_c1');
            $table->string('foto_diri_di_tps')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inputan_saksis');
    }
};
