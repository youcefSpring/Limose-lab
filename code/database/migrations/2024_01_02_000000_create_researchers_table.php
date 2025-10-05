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
        Schema::create('researchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('photo_path', 500)->nullable();
            $table->string('cv_path', 500)->nullable();
            $table->text('research_domain');
            $table->string('google_scholar_url', 500)->nullable();
            $table->text('bio_ar')->nullable();
            $table->text('bio_fr')->nullable();
            $table->text('bio_en')->nullable();
            $table->timestamps();

            // Indexes
            $table->fullText(['research_domain']);
            $table->fullText(['bio_ar', 'bio_fr', 'bio_en']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researchers');
    }
};