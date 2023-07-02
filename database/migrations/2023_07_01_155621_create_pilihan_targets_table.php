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
        Schema::create('pilihan_targets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_target_id');
            $table->bigInteger('soal_id');
            $table->bigInteger('pilihan_ganda_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilihan_targets');
    }
};
