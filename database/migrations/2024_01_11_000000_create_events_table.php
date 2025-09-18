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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar', 200);
            $table->string('title_fr', 200);
            $table->string('title_en', 200);
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->enum('type', ['seminar', 'workshop', 'conference', 'summer_school', 'meeting', 'other']);
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location_ar', 200)->nullable();
            $table->string('location_fr', 200)->nullable();
            $table->string('location_en', 200)->nullable();
            $table->integer('max_participants')->nullable();
            $table->date('registration_deadline')->nullable();
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->foreignId('organizer_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();

            // Indexes
            $table->index('organizer_id');
            $table->index('status');
            $table->index('type');
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
        Schema::dropIfExists('events');
    }
};