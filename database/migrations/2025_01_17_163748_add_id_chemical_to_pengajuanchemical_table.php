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
        Schema::table('pengajuanchemical', function (Blueprint $table) {
            // Menambahkan kolom id_chemical
            $table->unsignedBigInteger('id_chemical')->nullable()->after('nama_chemical');
            // Menambahkan foreign key ke tabel datachemical
            $table->foreign('id_chemical')->references('id')->on('datachemical')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuanchemical', function (Blueprint $table) {
            // Menghapus foreign key
            $table->dropForeign(['id_chemical']);
            // Menghapus kolom id_chemical
            $table->dropColumn('id_chemical');
        });
    }
};
