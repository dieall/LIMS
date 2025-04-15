<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseStatusColumnLengthInStatusHistories extends Migration
{
    public function up()
    {
        Schema::table('status_histories', function (Blueprint $table) {
            // Change status column to allow longer values
            $table->string('status', 100)->change(); // Increase to 100 characters
        });
    }

    public function down()
    {
        Schema::table('status_histories', function (Blueprint $table) {
            // Revert to original length if needed
            $table->string('status', 30)->change(); // Adjust to your original limit
        });
    }
}
