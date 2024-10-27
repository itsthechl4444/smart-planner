<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('inviter_id');
            $table->unsignedBigInteger('invitee_id');
            $table->string('token')->nullable();
            $table->boolean('accepted')->default(false);
            $table->timestamps();
    
            // Indexes and foreign keys
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('inviter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('invitee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
