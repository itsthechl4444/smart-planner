<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToBudgetsTable extends Migration
{
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->foreignId('user_id')->after('account_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
