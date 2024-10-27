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
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Cascade on user deletion
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->string('priority')->default('low'); // Default priority
            $table->unsignedBigInteger('label_id')->nullable(); // Nullable because not all tasks will have labels
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('set null'); // Set label to null if deleted
            $table->text('notes')->nullable();
            $table->string('attachments')->nullable();
            $table->boolean('reminder')->default(false); // Default value for reminders
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
