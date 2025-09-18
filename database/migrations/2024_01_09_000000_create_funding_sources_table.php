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
        Schema::create('funding_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar', 200);
            $table->string('name_fr', 200);
            $table->string('name_en', 200);
            $table->enum('type', ['government', 'private', 'international', 'university', 'other']);
            $table->text('contact_info')->nullable();
            $table->string('website', 500)->nullable();
            $table->timestamps();

            // Full text search
            $table->fullText(['name_ar', 'name_fr', 'name_en']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funding_sources');
    }
};