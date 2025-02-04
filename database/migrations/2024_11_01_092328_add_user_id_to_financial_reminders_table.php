<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToFinancialRemindersTable extends Migration
{
    public function up()
    {
        Schema::table('financial_reminders', function (Blueprint $table) {
            // Assuming you have a 'users' table with 'id' as the primary key
            $table->unsignedBigInteger('user_id')->after('id');

            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('financial_reminders', function (Blueprint $table) {
            // Drop foreign key and the column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
