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
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title_ar')->nullable();
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->text('content_ar')->nullable();
            $table->text('content_fr')->nullable();
            $table->text('content_en')->nullable();
            $table->string('type')->default('text'); // text, html, image, video
            $table->string('page')->nullable(); // home, about, contact, etc.
            $table->string('section')->nullable(); // header, hero, features, etc.
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
