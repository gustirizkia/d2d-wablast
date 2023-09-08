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
        Schema::create('suara_calegs', function (Blueprint $table) {
            $table->id();
            $table->string('input_saksi_uuid');
            $table->bigInteger('caleg_id');
            $table->bigInteger('jumlah_suara')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suara_calegs');
    }
};
