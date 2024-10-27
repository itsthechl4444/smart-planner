<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBudgetIdToExpensesTable extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('budget_id')->nullable()->after('user_id');

            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->dropColumn('budget_id');
        });
    }
}
