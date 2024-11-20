<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bqr', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->string('parameter', 255); // Kolom untuk parameter
            $table->string('spesification', 255); // Kolom untuk spesifikasi
            $table->string('methods', 255); // Kolom untuk methods
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bqr');
    }
};
