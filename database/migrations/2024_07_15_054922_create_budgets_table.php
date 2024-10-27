<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('category');
            $table->date('date');
            $table->string('period');
            $table->string('currency');
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->boolean('overspending_reminder')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}
