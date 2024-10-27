<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsTable extends Migration
{
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Add this line
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('desired_amount', 10, 2);
            $table->date('desired_date');
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('savings');
    }
}
