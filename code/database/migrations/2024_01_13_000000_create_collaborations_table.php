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
        Schema::create('collaborations', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar', 200);
            $table->string('title_fr', 200);
            $table->string('title_en', 200);
            $table->string('institution_name', 255);
            $table->string('country', 100);
            $table->string('contact_person', 100)->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('type', ['academic', 'industrial', 'governmental', 'international', 'other']);
            $table->enum('status', ['active', 'completed', 'suspended', 'cancelled'])->default('active');
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->foreignId('coordinator_id')->constrained('researchers')->onDelete('restrict');
            $table->timestamps();

            // Indexes
            $table->index('coordinator_id');
            $table->index('status');
            $table->index('type');
            $table->index('country');
            $table->fullText(['title_ar', 'title_fr', 'title_en']);
            $table->fullText(['institution_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborations');
    }
};