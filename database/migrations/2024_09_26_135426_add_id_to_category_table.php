<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToCategoryTable extends Migration
{
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->id()->first(); // Menambahkan kolom id sebagai kolom pertama
        });
    }

    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('id'); // Menghapus kolom id
        });
    }
}
