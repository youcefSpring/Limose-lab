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
        Schema::create('publication_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publication_id')->constrained('publications')->onDelete('cascade');
            $table->foreignId('researcher_id')->constrained('researchers')->onDelete('cascade');
            $table->unsignedSmallInteger('author_order')->default(1);
            $table->boolean('is_corresponding_author')->default(false);
            $table->timestamps();

            // Unique constraint
            $table->unique(['publication_id', 'researcher_id']);

            // Indexes
            $table->index('publication_id');
            $table->index('researcher_id');
            $table->index('author_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publication_authors');
    }
};