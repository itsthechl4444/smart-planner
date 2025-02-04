<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialRemindersTable extends Migration
{
    public function up()
    {
        Schema::create('financial_reminders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('due_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_reminders');
    }
}
