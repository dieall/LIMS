<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoaApprovalColumnsToStatusHistories extends Migration
{
    public function up()
    {
        Schema::table('status_histories', function (Blueprint $table) {
            $table->boolean('is_approved')->nullable()->after('status');
            $table->string('rejection_reason')->nullable()->after('is_approved');
        });
    }

    public function down()
    {
        Schema::table('status_histories', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'rejection_reason']);
        });
    }
}
