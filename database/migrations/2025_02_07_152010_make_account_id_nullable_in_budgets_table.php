<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAccountIdNullableInBudgetsTable extends Migration
{
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            // Drop the existing foreign key constraint.
            $table->dropForeign(['account_id']);

            // Modify the column to be nullable.
            $table->unsignedBigInteger('account_id')->nullable()->change();

            // Re-add the foreign key constraint.
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            // Drop the foreign key constraint.
            $table->dropForeign(['account_id']);

            // Change the column back to NOT NULL.
            $table->unsignedBigInteger('account_id')->nullable(false)->change();

            // Re-add the original foreign key constraint.
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }
}
