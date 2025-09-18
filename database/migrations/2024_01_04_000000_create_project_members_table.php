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
        Schema::create('project_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('researcher_id')->constrained('researchers')->onDelete('cascade');
            $table->string('role', 100)->default('member');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();

            // Unique constraint
            $table->unique(['project_id', 'researcher_id']);

            // Indexes
            $table->index('project_id');
            $table->index('researcher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};