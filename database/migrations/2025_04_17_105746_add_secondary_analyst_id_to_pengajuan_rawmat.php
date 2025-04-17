<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecondaryAnalystIdToPengajuanRawmat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbr_pengajuan', function (Blueprint $table) {
            $table->unsignedBigInteger('secondary_analyst_id')->nullable()->after('user_id');
            $table->foreign('secondary_analyst_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbr_pengajuan', function (Blueprint $table) {
            $table->dropForeign(['secondary_analyst_id']);
            $table->dropColumn('secondary_analyst_id');
        });
    }
}
