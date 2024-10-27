<?php

// database/migrations/YYYY_MM_DD_create_debts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('currency');
            $table->enum('type', ['borrowed', 'lent']);
            $table->date('due_date')->nullable();
            $table->boolean('reminder')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debts');
    }
}

