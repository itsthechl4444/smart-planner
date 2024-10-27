<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingAmountsTable extends Migration
{
    public function up()
    {
        Schema::create('saving_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user_id field
            $table->foreignId('saving_id')->constrained()->onDelete('cascade'); // saving_id field (related to Saving table)
            $table->decimal('amount', 10, 2); // stores the amount saved
            $table->timestamps(); // timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('saving_amounts');
    }
}
