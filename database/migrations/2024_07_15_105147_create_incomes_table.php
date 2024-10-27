<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('source_name');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
