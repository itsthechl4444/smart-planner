<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTasksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Assigned user
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('priority', ['High', 'Medium', 'Low'])->default('Medium');
            $table->foreignId('label_id')->nullable()->constrained()->onDelete('set null');
            $table->text('notes')->nullable();
            $table->string('attachments')->nullable();
            $table->boolean('reminder')->default(false);
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('project_tasks');
    }
}
