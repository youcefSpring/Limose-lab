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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('title_fr')->nullable();
            $table->string('title_ar')->nullable();
            $table->text('abstract')->nullable();
            $table->text('abstract_fr')->nullable();
            $table->text('abstract_ar')->nullable();
            $table->string('authors');
            $table->string('journal')->nullable();
            $table->string('conference')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('year');
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->string('pages')->nullable();
            $table->string('doi')->nullable();
            $table->string('isbn')->nullable();
            $table->string('url')->nullable();
            $table->string('pdf_file')->nullable();
            $table->enum('type', ['journal', 'conference', 'book', 'chapter', 'thesis', 'preprint', 'other'])->default('journal');
            $table->enum('status', ['published', 'in_press', 'submitted', 'draft'])->default('published');
            $table->date('publication_date')->nullable();
            $table->text('keywords')->nullable();
            $table->text('research_areas')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_open_access')->default(false);
            $table->integer('citations_count')->default(0);
            $table->enum('visibility', ['public', 'private', 'pending'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
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
