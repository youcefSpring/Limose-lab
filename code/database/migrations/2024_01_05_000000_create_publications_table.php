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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->text('authors');
            $table->string('journal', 255)->nullable();
            $table->string('conference', 255)->nullable();
            $table->string('publisher', 255)->nullable();
            $table->string('doi', 200)->nullable()->unique();
            $table->year('publication_year');
            $table->string('volume', 50)->nullable();
            $table->string('issue', 50)->nullable();
            $table->string('pages', 50)->nullable();
            $table->enum('type', ['article', 'conference', 'patent', 'book', 'poster']);
            $table->string('pdf_path', 500)->nullable();
            $table->enum('status', ['draft', 'submitted', 'published', 'archived'])->default('draft');
            $table->foreignId('created_by')->constrained('researchers')->onDelete('restrict');
            $table->timestamps();

            /* Indexes
            $table->index('publication_year');
            $table->index('type');
            $table->index('status');
            $table->index('created_by');
            $table->fullText(['title', 'authors']);
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};