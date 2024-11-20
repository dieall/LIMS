<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tc191', function (Blueprint $table) {
            $table->id('id_tc191')->after('column_name'); // Ganti 'column_name' dengan nama kolom setelah yang Anda inginkan
        });
    }
    
    public function down()
    {
        Schema::table('tc191', function (Blueprint $table) {
            $table->dropColumn('id_tc191');
        });
    }
    
};
