<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('event', 100); // e.g., 'created', 'updated', 'deleted', 'viewed'
            $table->string('subject_type', 100); // Model class name
            $table->unsignedBigInteger('subject_id'); // Model ID
            $table->string('description', 255); // Human readable description
            $table->json('properties')->nullable(); // Additional data about the activity
            $table->json('changes')->nullable(); // What changed (before/after)
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at');

            // Indexes
            $table->index('user_id');
            $table->index('event');
            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};