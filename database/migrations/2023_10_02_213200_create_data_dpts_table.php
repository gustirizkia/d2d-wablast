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
        Schema::create('data_dpts', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("jenis_kelamin");
            $table->char("usia", 8);
            $table->string("desa");
            $table->string("rw");
            $table->string("rt");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_dpts');
    }
};
