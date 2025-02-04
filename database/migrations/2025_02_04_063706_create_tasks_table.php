<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('due_date')->nullable();

            // If your validation is in: 'priority' => 'in:High,Medium,Low',
            // set the default to match one of those (e.g., 'Low')
            $table->string('priority')->default('Low');

            $table->unsignedBigInteger('label_id')->nullable();
            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->onDelete('set null');

            $table->text('notes')->nullable();

            // Single attachment path - plain string (no JSON)
            // If you expect long file paths, consider text() instead of string()
            $table->string('attachments')->nullable();

            $table->boolean('reminder')->default(false);
            $table->string('status')->default('pending');
            $table->boolean('completed')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
