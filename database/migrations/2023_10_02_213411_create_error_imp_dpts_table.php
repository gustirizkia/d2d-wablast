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
        Schema::create('error_imp_dpts', function (Blueprint $table) {
            $table->id();
            $table->string("row_index")->nullable();
            $table->longText("row_data")->nullable();
            $table->longText("error_message");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_imp_dpts');
    }
};
