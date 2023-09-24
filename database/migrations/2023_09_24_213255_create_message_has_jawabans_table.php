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
        Schema::create('message_has_jawabans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("message_id");
            $table->bigInteger("soal_id");
            $table->bigInteger("pilihan_id")->nullable();
            $table->string("ya_tidak")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_has_jawabans');
    }
};
