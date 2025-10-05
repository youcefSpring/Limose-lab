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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leader_id')->constrained('researchers')->onDelete('restrict');
            $table->string('title_ar', 200);
            $table->string('title_fr', 200);
            $table->string('title_en', 200);
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->decimal('budget', 15, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending', 'active', 'completed', 'suspended'])->default('pending');
            $table->timestamps();

            // Indexes
            $table->index('leader_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
            $table->fullText(['title_ar', 'title_fr', 'title_en']);
            $table->fullText(['description_ar', 'description_fr', 'description_en']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};