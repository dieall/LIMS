<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_solder_id');
            $table->string('status');
            $table->timestamps();
    
            $table->foreign('pengajuan_solder_id')->references('id')->on('tbs_pengajuan_solders')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('status_histories');
    }
    
};
